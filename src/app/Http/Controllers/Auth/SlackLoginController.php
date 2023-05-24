<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class SlackLoginController extends Controller
{
    /**
     * SlackのクライアントID
     */
    public function __construct()
    {
        $this->client_id = Config::get('services.slack.client_id');
        $this->client_secret = Config::get('services.slack.client_secret');
        $this->redirect_uri = Config::get('services.slack.redirect');
    }

    /**
     * Slackへのリダイレクト処理
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToSlack()
    {
        $state = csrf_token();
        $nonce = uniqid();
        request()->session()->put('nonce', $nonce);

        $to = "https://slack.com/openid/connect/authorize" .
            "?response_type=code" .
            "&scope=openid,email" .
            "&state={$state}" .
            "&nonce={$nonce}" .
            "&client_id={$this->client_id}" .
            "&redirect_uri={$this->redirect_uri}";

        return redirect($to);
    }

    /**
     * Slackコールバック処理
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleSlackCallback()
    {
        // state の検証
        if (csrf_token() !== request('state')) {
            abort(401);
        }

        // id_token のリクエスト
        $client = new \GuzzleHttp\Client();
        $res = $client->request('POST', "https://slack.com/api/openid.connect.token", [
            'form_params' => [
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret,
                'code' => request('code'),
                'redirect_uri' => $this->redirect_uri
            ]
        ]);

        // レスポンスのステータスチェック
        $status = $res->getStatusCode();
        if ($status !== 200) {
            abort(401);
        }
        $contents = json_decode($res->getBody()->getContents());
        if (!$contents->ok) {
            abort(401);
        }

        // JWT の payload の取得
        $id_token = explode('.', $contents->id_token);
        $payload = json_decode(base64_decode($id_token[1]));


        // nonce の検証
        $session_nonce = request()->session()->pull('nonce');
        if ($session_nonce !== $payload->nonce) {
            abort(401);
        }

        // ユーザの取得
        $user = User::where('email', $payload->email)->firstOrFail();

        // ログイン処理
        Auth::login($user);
        request()->session()->regenerate();
        return redirect('/items');
    }
}