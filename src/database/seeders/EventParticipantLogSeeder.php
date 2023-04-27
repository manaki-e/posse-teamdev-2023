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
        foreach ($event_ids as $event_id) {
            $random_user_ids = $faker->randomElements($user_ids, rand(0, 3));
            foreach ($random_user_ids as $user_id) {
                $event_participants_array[] = [
                    'event_id' => $event_id,
                    'user_id' => $user_id,
                    'point' => $faker->numberBetween(0, env('MAXIMUM_EVENT_PARTICIPATE_FEE')),
                    'deleted_at' => $faker->randomElement([null, now()])
                ];
            }
        }
        DB::table('event_participant_logs')->insert($event_participants_array);
        //usersテーブルのpointカラムを更新
        $event_participant_log_instance = new EventParticipantLog();
        $event_participant_logs = $event_participant_log_instance->where('deleted_at', null)->get();
        //過去の全てのイベント分のポイントを足す
        $event_participant_logs->each(function ($event_participant) {
            //参加者からポイント引く
            $user_instance=new User();
            $user=$user_instance->find($event_participant->user_id);
            $user->update([
                'distribution_point' => $user->distribution_point - $event_participant->point
            ])
            $event_participant->user->update([
                'point' => $event_participant->user->point - $event_participant->point
            ]);
        });
    }
}