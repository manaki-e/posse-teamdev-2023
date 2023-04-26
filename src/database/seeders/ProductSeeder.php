<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Request;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $status=Product::STATUS;
        $request_ids=Request::getRequestIds();
        $user_ids=User::getUserIds();
        //申請中アイテム
        for ($i = 1; $i <= 10; $i++) {
            $products_array[] = [
                'title' => 'アイテム'.$i,
                'point' => null,
                'description' => "これはアイテム".$i."の備考です。\nこれはアイテム".$i."の備考です。",
                'status'=>$status['pending'],
                'request_id'=>$faker->randomElement($request_ids),
                'user_id'=>$faker->randomElement($user_ids),
                'created_at' => now()
            ];
        }
        //利用中、利用可能アイテム
        for($i=11;$i<=20;$i++){
            $products_array[] = [
                'title' => 'アイテム'.$i,
                'point' => $faker->randomElement([100, 200, 300, 400, 500]),
                'description' => "これはアイテム" . $i . "の備考です。\nこれはアイテム" . $i . "の備考です。",
                'status'=>$status['available'],
                'request_id'=>$faker->randomElement($request_ids),
                'user_id'=>$faker->randomElement($user_ids),
                'created_at' => now()
            ];
        }
        //利用中アイテム
        for($i=21;$i<=30;$i++){
            $products_array[] = [
                'title' => 'アイテム'.$i,
                'point' => $faker->randomElement([100, 200, 300, 400, 500]),
                'description' => "これはアイテム" . $i . "の備考です。\nこれはアイテム" . $i . "の備考です。",
                'status'=>$status['occupied'],
                'request_id'=>$faker->randomElement($request_ids),
                'user_id'=>$faker->randomElement($user_ids),
                'created_at' => now()
            ];
        }
        DB::table('products')->insert($products_array);
    }
}