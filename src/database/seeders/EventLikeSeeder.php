<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class EventLikeSeeder extends Seeder
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
        $user_id_count = count($user_ids);
        foreach ($event_ids as $event_id) {
            $random_user_ids = $faker->randomElements($user_ids, $faker->numberBetween(0, $user_id_count));
            foreach ($random_user_ids as $user_id) {
                $product_likes_array[] = [
                    'event_id' => $event_id,
                    'user_id' => $user_id,
                ];
            }
        }
        DB::table('event_likes')->insert($product_likes_array);
    }
}