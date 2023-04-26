<?php

namespace Database\Seeders;

use App\Models\PointExchange;
use App\Models\User;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PointExchangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $user_ids=User::getUserIds();
        for ($i = 0; $i < 10; $i++) {
            $random_number = PointExchange::MULTIPLE_OF * $faker->numberBetween(1, 10);
            $point_exchanges_array[] = ['point' => $random_number, 'user_id' => $faker->randomElement($user_ids),'created_at'=>now()];
        }
        DB::table('point_exchanges')->insert($point_exchanges_array);
    }
}