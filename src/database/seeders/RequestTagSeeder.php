<?php

namespace Database\Seeders;

use App\Models\Request;
use App\Models\RequestTag;
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
        $request_ids=Request::getRequestIds();
        $request_tag_array=[];
        $request_tag_instance=new RequestTag();
        foreach($request_ids as $request){
            $tag_count=$faker->numberBetween(1,3);
            $tags=$request_tag_instance->getMultipleTags($tag_count);
            foreach($tags as $tag){
                $request_tag_array[]=[
                    'request_id'=>$request->id,
                    'tag_id'=>$tag->id,
                ];
            }
        }
        DB::table('request_tag')->insert($request_tag_array);
    }
}
