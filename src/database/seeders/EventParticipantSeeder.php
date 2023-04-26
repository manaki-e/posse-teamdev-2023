<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class EventParticipantSeeder extends Seeder
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
                    'point' => $faker->numberBetween(0,env('MAXIMUM_EVENT_PARTICIPATE_FEE')),
                    'deleted_at'=>$faker->randomElement([null, now()])
                ];
            }
        }
        DB::table('event_participants')->insert($event_participants_array);
    }
}