<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker=Faker::create();
        for ($i = 1; $i <= 10; $i++) {
            $requests_array[] = [
                'title' => 'リクエスト' . $i,
                'description' => 'これはリクエスト' . $i . 'の備考です。',
                'user_id' => $faker->randomElement(User::getUserIds()),
                'request_type_id' => $faker->randomElement(RequestType::getRequestTypeIds()),
                'created_at' => now()
            ];
        }
        DB::table('product_statuses')->insert($product_tags_array);
    }
}