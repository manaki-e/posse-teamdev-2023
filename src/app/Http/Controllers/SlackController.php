<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use App\Models\SlackUser;
use App\Models\User;

class SlackController extends Controller
{
    /**
     * @var string $token Slackのトークン
     */
    private $token;

    /**
     * SlackController constructor.
     */
    public function __construct()
    {
        $this->token = env('SLACK_TOKEN');
    }

    /**
     * Slackのユーザー情報を取得してDBに登録する
     * @param Request $request
     * @return void
     */
    public function createUsers(Request $request)
    {
        $client = new Client();
        $retryAttempts = 10; // 再試行回数
        $retryDelay = 1; // 待機時間（秒）
        $response = null;
        $attempts = 0;

        do {
            try {
                $response = $client->request('GET', 'https://slack.com/api/users.list', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->token,
                        'Content-type' => 'application/json'
                    ]
                ]);
                $users = json_decode($response->getBody())->members;
                foreach ($users as $user) {
                    if (isset($user->profile->email) && !SlackUser::where('email', $user->profile->email)->exists()) {
                        DB::table('slack_users')->insert([
                            [
                                'name' => $user->profile->real_name,
                                'display_name' => $user->profile->display_name,
                                'email' => $user->profile->email,
                                'icon' => $user->profile->image_512,
                                'slackID' => $user->id,
                                'department_name' => $user->profile->title,
                                'created_at' => now(),
                            ]
                        ]);
                    }
                }
                SlackUser::wherenotIn('slackID', array_column($users, 'id'))->delete();
            } catch (RequestException $e) {
                if ($e->getResponse()->getStatusCode() == 429) { // レート制限エラー
                    if ($attempts >= $retryAttempts) {
                        // 再試行回数を超えた場合はエラーを投げる
                        throw $e;
                    }
                    // 待機時間を設けてから再試行する
                    sleep($retryDelay);
                    $attempts++;
                } else {
                    // その他のエラーは例外を投げる
                    throw $e;
                }
            }
        } while ($response === null);

        return Redirect::route('admin.users.index');
    }

    /**
     * Slackに通知を送信する
     * @param Request $request
     * @param array $payload 送信する通知のペイロード
     * @return void
     */
    public function sendNotification(Request $request)
    {
        // 送信する通知のペイロードを作成
        // https://api.slack.com/methods/chat.postMessage
        /**
         * @var array $payload 送信する通知のペイロード
         * @var string $payload['channel'] チャンネル名
         * @var string $payload['text'] 送信するテキスト
         */
        $payload = [
            'channel' => 'U0572LXKNLA',
            'text' => '<@U056W35F71C> さんがあなたの本を借りました.',
        ];

        // Slack APIにPOSTリクエストを送信
        $response = Http::withToken($this->token)
            ->post('https://hooks.slack.com/api/chat.postMessage', $payload);

        // 実行する
        $response->throw();
    }

    /**
     * Slackにチャンネルを作成する
     * @param Request $request
     * @param string $channel_name 作成するチャンネル名
     * @param string $invite_users 招待するユーザーのSlackID
     * @return void
     */
    public function createChannel($event_title)
    {
        $user = Auth::user();

        $create_user = User::where('id', $user->id)->pluck('slackID')->join(', ');
        $admin_users = User::where('is_admin', 1)->pluck('slackID')->join(', ');
        $invite_users = $create_user . ', ' . $admin_users;

        $channel_name = 'peerevent-' . $event_title;
        $valid_channel_name = strtolower(str_replace([' ', '.'], '', $channel_name));
        $channel = [
            'name' => $valid_channel_name
        ];

        // Slack APIにPOSTリクエストを送信
        $response = Http::withToken($this->token)
            ->post('https://slack.com/api/conversations.create', $channel);

        // チャンネル作成が成功した場合のみユーザを招待
        if ($response->json()['ok']) {
            $channel_id = $response->json()['channel']['id'];
            $this->inviteUsers($channel_id, $invite_users);
        } else {
            return Redirect::route('events.index')->with(['flush.message' => 'なんらかのエラーが発生してイベントを作成できませんでした。', 'flush.alert_type' => 'error']);
        }

        return $channel_id;
    }

    /**
     * Slackにチャンネルにユーザーを招待する
     * @param string $channelId 招待するチャンネルID
     * @param string $invite_users 招待するユーザーのSlackID
     * @return void
     */
    public function inviteUsers($channel_id, $invite_users)
    {
        // ユーザを招待する情報を準備
        $invite_data = [
            'channel' => $channel_id,
            'users' => $invite_users,
        ];

        // Slack APIにPOSTリクエストを送信してユーザを招待
        $invite_response = Http::withToken($this->token)
        ->post('https://slack.com/api/conversations.invite', $invite_data);

        if ($invite_response->successful()) {
            return;
        } else {
            return Redirect::route('events.index')->with(['flush.message' => 'なんらかのエラーが発生してイベントを作成できませんでした。', 'flush.alert_type' => 'error']);
        }
    }

    /**
     * ユーザIDの配列をカンマ区切りのslackIDに変換する
     * @param array $user ユーザIDの配列
     * @return string $user_slack_id カンマ区切りのslackID
     */
    public function getUserSlackIds($users)
    {
        $user_slack_id = User::whereIn('id', $users)->pluck('slackID')->join(', ');

        return $user_slack_id;
    }
}

// 現時点でのユーザ情報

// string(8) "Slackbot"
// string(9) "USLACKBOT"

// string(24) "井戸宗達/Ido Sohtatu"
// string(11) "U056N55T9AB"

// string(31) "高梨 彩音 / Ayane Takahashi"
// string(11) "U056W35F71C"

// string(26) "遠藤愛期 / Manaki Endo"
// string(11) "U0572LXKNLA"

// string(8) "PeerPerk"
// string(11) "U0572Q3RJQJ"

// string(18) "M22y10m20 Yoshikun"
// string(11) "U057562KC7N"

// string(25) "古屋美羽 / Miu Furuya"
// string(11) "U057FAD67R7"

// string(25) "本城裕大 / Yuta Honjo"
// string(11) "U057SC3MRKJ"
