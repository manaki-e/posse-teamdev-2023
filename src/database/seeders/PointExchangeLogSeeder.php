<?php

namespace Database\Seeders;

use App\Models\PointExchangeLog;
use App\Models\User;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Carbon;

class PointExchangeLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $user_ids = User::getUserIds();
        $multiple_of = PointExchangeLog::MULTIPLE_OF;
        $last_month = Carbon::now()->subMonth();
        $status = PointExchangeLog::STATUS;
        for ($i = 0; $i < 10; $i++) {
            $random_number = $multiple_of * $faker->numberBetween(1, 10);
            $random_status = $faker->randomElement($status);
            if ($random_status === $status['PENDING']) {
                $point_exchanges_array[] = ['point' => $random_number, 'user_id' => $faker->randomElement($user_ids), 'created_at' => $last_month, 'updated_at' => null, 'status' => $random_status];
            } else {
                $point_exchanges_array[] = ['point' => $random_number, 'user_id' => $faker->randomElement($user_ids), 'created_at' => $last_month, 'updated_at' => $faker->dateTimeBetween($last_month), 'status' => $random_status];
            }
        }
        DB::table('point_exchange_logs')->insert($point_exchanges_array);
    }
}