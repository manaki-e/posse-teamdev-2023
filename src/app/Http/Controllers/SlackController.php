<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Models\Department;

class SlackController extends Controller
{
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
                        'Authorization' => 'Bearer ' . env('SLACK_TOKEN'),
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
}
