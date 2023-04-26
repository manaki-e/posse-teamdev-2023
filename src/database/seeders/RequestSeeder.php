<?php

namespace Database\Seeders;

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
        for ($i = 1; $i <= 10; $i++) {
            $requests_array[] = [
                'title' => 'リクエスト' . $i,
                'description' => 'これはリクエスト' . $i . 'の備考です。',
                'user_id' => $faker->randomElement(User::getUserIds()),
                'request_type_id'=>$faker->randomElement(RequestType::getRequestTypeIds()),
                'created_at' => now()
            ];
        }
        DB::table('requests')->insert($requests_array);
    }
}