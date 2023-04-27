<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use App\Models\EventParticipantLog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;


class EventParticipantLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $event_ids = Event::getEventIds();
        $user_ids = User::getUserIds();
        $events = new Event();
        foreach ($event_ids as $event_id) {
            $random_user_ids = $faker->randomElements($user_ids, rand(0, 3));
            foreach ($random_user_ids as $user_id) {
                $event_participants_array[] = [
                    'event_id' => $event_id,
                    'user_id' => $user_id,
                    'point' => $faker->numberBetween(0, env('MAXIMUM_EVENT_PARTICIPATE_FEE')),
                    'deleted_at' => $faker->randomElement([null, now()]),
                    'created_at' => $faker->dateTimeBetween('-1 month', 'now'),
                ];
            }
        }
        DB::table('event_participant_logs')->insert($event_participants_array);
        //usersテーブルのpointカラムを更新
        //過去の開催された全てのイベント分のポイントを開催者に足す
        $all_completed_events = $events->completedEvents()->with('participants')->get();
        $all_completed_events->each(function ($event) {
            $point_sum = 0;
            $event->participants->each(function ($participant) use (&$point_sum) {
                $point_sum += $participant->point;
            });
            if ($point_sum !== 0) {
                $user_instance = User::findOrFail($event->user_id);
                $user_instance->update(['earned_point' => $point_sum + $user_instance->earned_point]);
            }
        });
        //今月参加登録した参加者からポイント引く
        $event_participant_log_instance=new EventParticipantLog();
        $event_participant_log_grouped_by_user=$event_participant_log_instance->createdThisMonth()->get()->groupBy('user_id');
        $event_participant_log_grouped_by_user->each(function($event_participant_log,$user_id){
            $user_instance=User::findOrFail($user_id);
            $point_sum=$event_participant_log->sum('point');
            $user_instance->update(['distribution_point'=>$user_instance->distribution_point-$point_sum]);
        });
    }
}