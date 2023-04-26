<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class EventTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $tag_instance = new Tag();
        $event_tags = $tag_instance->getTagIdsByRequestTypeId(Tag::REQUEST_TYPE_ID['event']);
        $event_ids = Event::getEventIds();
        foreach ($event_ids as $event_id) {
            $tag_count = $faker->numberBetween(0, 2);
            $random_event_tags = $faker->randomElements($event_tags, $tag_count);
            foreach ($random_event_tags as $random_event_tag) {
                $event_tags_array[] = [
                    'event_id' => $event_id,
                    'tag_id' => $random_event_tag,
                ];
            }
        }
        DB::table('event_tag')->insert($event_tags_array);
    }
}