<?php

namespace Database\Seeders;

use App\Models\ProductStatus;
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
        $pending_product_status_id = ProductStatus::PENDING_PRODUCT_STATUS_ID;
        $available_product_status_id = ProductStatus::AVAILABLE_PRODUCT_STATUS_ID;
        $occupied_product_status_id = ProductStatus::OCCUPIED_PRODUCT_STATUS_ID;
        $request_ids=Request::getRequestIds();
        $user_ids=User::getUserIds();
        //申請中アイテム
        for ($i = 1; $i <= 10; $i++) {
            $products_array[] = [
                'title' => 'アイテム'.$i,
                'point' => null,
                'description' => 'これはアイテム'.$i.'の備考です。',
                'product_status_id'=>$pending_product_status_id,
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
                'description' => 'これはアイテム'.$i.'の備考です。',
                'product_status_id'=>$available_product_status_id,
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
                'description' => 'これはアイテム'.$i.'の備考です。',
                'product_status_id'=>$occupied_product_status_id,
                'request_id'=>$faker->randomElement($request_ids),
                'user_id'=>$faker->randomElement($user_ids),
                'created_at' => now()
            ];
        }
        DB::table('products')->insert($products_array);
    }
}