<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;

use App\Models\RequestType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class RequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $today = Carbon::now();
        $yesterday = $today->subDay();
        $user_ids = User::getUserIds();
        $request_type_ids = RequestType::getRequestTypeIds();
        //未対応
        for ($i = 1; $i <= 10; $i++) {
            $requests_array[] = [
                'title' => 'リクエスト' . $i,
                'description' => 'これはリクエスト' . $i . 'の備考です。',
                'user_id' => $faker->randomElement($user_ids),
                'request_type_id' => $faker->randomElement($request_type_ids),
                'created_at' => $today,
                'completed_at' => null
            ];
        }
        //対応済み
        for ($i = 11; $i <= 20; $i++) {
            $requests_array[] = [
                'title' => 'リクエスト' . $i,
                'description' => 'これは対応済みのリクエスト' . $i . 'の備考です。',
                'user_id' => $faker->randomElement($user_ids),
                'request_type_id' => $faker->randomElement($request_type_ids),
                'created_at' => $yesterday,
                'completed_at' => $today
            ];
        }
        DB::table('requests')->insert($requests_array);
    }
}