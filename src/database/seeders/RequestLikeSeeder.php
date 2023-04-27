<?php

namespace Database\Seeders;

use App\Models\Request;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class RequestLikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $request_ids = Request::getRequestIds();
        $user_ids = User::getUserIds();
        $user_id_count = count($user_ids);
        foreach ($request_ids as $request_id) {
            $random_user_ids = $faker->randomElements($user_ids, $faker->numberBetween(0, $user_id_count));
            foreach ($random_user_ids as $user_id) {
                $request_likes_array[] = [
                    'request_id' => $request_id,
                    'user_id' => $user_id,
                ];
            }
        }
        DB::table('request_likes')->insert($request_likes_array);
    }
}