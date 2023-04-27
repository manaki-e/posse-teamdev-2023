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
            $point_exchanges_array[] = ['point' => $random_number, 'user_id' => $faker->randomElement($user_ids), 'created_at' => $last_month, 'status' => $faker->randomElement($status)];
        }
        DB::table('point_exchange_logs')->insert($point_exchanges_array);
        //usersテーブルのearned_pointカラムを更新=>default0だから換金したらマイナスになる
        //却下されたらポイント増やす、承認されたらポイントそのままにする
        $point_exchange_log_instance = new PointExchangeLog();
        $point_exchange_logs_rejected= $point_exchange_log_instance->rejected()->get()->groupBy('user_id');
        $point_exchange_logs_rejected->each(function($point_exchange_logs,$user_id){
            $point_sum = $point_exchange_logs->sum('point');
            $user_instance = User::findOrFail($user_id);
            print_r('before'.$user_instance->earned_point);
            $user_instance->update(['earned_point'=>$user_instance->earned_point+$point_sum]);
            print_r('after'.$user_instance->earned_point."\n");
        });
    }
}