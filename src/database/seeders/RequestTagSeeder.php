<?php

namespace Database\Seeders;

use App\Models\Request;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class RequestTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $requests = Request::get();
        $tag_instance = new Tag();
        $product_request_type_id = Request::PRODUCT_REQUEST_TYPE_ID;
        $event_request_type_id = Request::EVENT_REQUEST_TYPE_ID;
        $tags = [
            $product_request_type_id => $tag_instance->getIdsByRequestTypeId($product_request_type_id),
            $event_request_type_id => $tag_instance->getIdsByRequestTypeId($event_request_type_id)
        ];
        foreach ($requests as $request) {
            $tag_count = $faker->numberBetween(1, 3);
            $random_tag_ids = $faker->randomElements($tags[$request->type_id], $tag_count);
            foreach ($random_tag_ids as $random_tag_id) {
                $request_tag_array[] = [
                    'request_id' => $request->id,
                    'tag_id' => $random_tag_id,
                ];
            }
        }
        DB::table('request_tag')->insert($request_tag_array);
    }
}