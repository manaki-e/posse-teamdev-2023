<?php

namespace Database\Seeders;

use App\Models\PointExchange;
use App\Models\User;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Carbon;

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
        $multiple_of=PointExchange::MULTIPLE_OF;
        $last_month=Carbon::now()->subMonth();
        $status=PointExchange::STATUS;
        for ($i = 0; $i < 10; $i++) {
            $random_number = $multiple_of * $faker->numberBetween(1, 10);
            $point_exchanges_array[] = ['point' => $random_number, 'user_id' => $faker->randomElement($user_ids),'created_at'=>$last_month,'status'=>$faker->randomElement($status)];
        }
        DB::table('point_exchanges')->insert($point_exchanges_array);
    }
}