<?php

namespace Database\Seeders;

use App\Models\EventParticipant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PointLog;
use App\Models\ProductDeal;
use Illuminate\Support\Facades\DB;

class PointLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $earned_point_type=PointLog::EARNED_POINT_TYPE;
        $distribution_point_type=PointLog::DISTRIBUTION_POINT_TYPE;
        //point_logsには稼ぐ側と支払う側の両方を入れる
        //稼ぐ側には全て、支払う側は今月のみusersテーブルに反映させる
        $all_event_participants=EventParticipant::all();
        $current_month_event_participants=$all_event_participants->currentMonth();
        $all_product_deals=ProductDeal::all();
        $current_month_product_deals=$all_product_deals->currentMonth();
        //event_participantsをpoint_logs_arrayにいれて
        $point_logs_array[]=[
            'user_id' => 1,
            'event_id'=>,
            'product_id'=>,
            'point'=>,
            'point_type'=>,
        ];
        //product_dealsをpoint_logs_arrayにいれて
        DB::table('point_logs')->insert($point_logs_array);
        // created_atでソートしてpoint_logsに反映させる
        //point_logsの今月の物のみusersテーブルのpointに反映させる
    }
}