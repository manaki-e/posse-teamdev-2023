<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Models\Department;

class SlackController extends Controller
{

    private $token;

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
                    if (empty($user->profile->title)) {
                        $department_id = null;
                    } else {
                        $department = Department::firstOrCreate(['name' => $user->profile->title]);
                        $department_id = $department->id;
                    }

                    DB::table('users')->insert([
                        [
                            'name' => $user->real_name,
                            'email' => $user->name . '@anti-pattern.co.jp',
                            'password' => Hash::make('password'),
                            'icon' => $user->profile->image_48,
                            'slackID' => $user->id,
                            'is_admin' => 0,
                            'department_id' => $department_id,
                            'created_at' => now(),
                        ]
                    ]);
                }
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
    public function createChannel(Request $request)
    {
        // 引数として受け取る値を想定
        $channel_name = 'latest';
        $invite_users = 'U056N55T9AB, U0572LXKNLA';

        // 作成するチャンネルの情報
        $channel = [
            'name' => $channel_name,
        ];

        // Slack APIにPOSTリクエストを送信
        $response = Http::withToken($this->token)
            ->post('https://slack.com/api/conversations.create', $channel);

        // チャンネルを作成して、そのチャンネルのIDを取得
        $channelId = $response->json()['channel']['id'];

        $this->inviteUsers($request, $channelId, $invite_users);
    }

    /**
     * Slackにチャンネルにユーザーを招待する
     * @param Request $request
     * @param string $channelId 作成するチャンネルのID
     * @param string $invite_users 招待するユーザーのSlackID
     * @return void
     */
    public function inviteUsers(Request $request, $channelId, $invite_users)
    {
        // 全てのチャンネルに必要なユーザ（例えば管理者など）を追加
        $invite_users .= ',U056W35F71C';

        // 招待するチャンネルの情報とユーザの情報
        $invite_channel = [
            'channel' => $channelId,
            'users' => $invite_users,
        ];

        // Slack APIにPOSTリクエストを送信
        $response = Http::withToken($this->token)
            ->post('https://slack.com/api/conversations.invite', $invite_channel);

        // チャンネルに招待する
        $response->throw();
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
