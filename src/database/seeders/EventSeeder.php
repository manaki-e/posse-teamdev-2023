<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class EventSeeder extends Seeder
{
    public $slack_channels = [];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('ja_JP');
        for ($i = 1; $i <= 10; $i++) {
            $user_id = $faker->randomElement(User::getUserIds());
            $date = $faker->dateTimeBetween('today', '+1 month');
            $events_array[] = [
                'user_id' => $user_id,
                'title' => 'イベント' . $i,
                'description' => "イベント" . $i . "の説明\nイベント" . $i . "の説明",
                'date' => $faker->randomElement([null, $date]),
                'location' => $faker->randomElement(['オンライン', $faker->address]),
                'slack_channel' => $this->channelId(),
                'completed_at' => $date
            ];
        }
        DB::table('events')->insert($events_array);
    }
    public function channelId()
    {
        do {
            $id = str_pad(rand(1, 99999999), 8, "0", STR_PAD_LEFT);
            $this->slack_channels[] = 'C' . $id;
        } while (in_array($id, $this->slack_channels));
        return 'C' . $id;
    }
}