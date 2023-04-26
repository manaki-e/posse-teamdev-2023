<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Product;
use App\Models\ProductDeal;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProductDealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $product_ids = Product::getAvailableProductIds();
        $user_ids = User::getUserIds();
        //返却済み
        //ポイントの変動とステータスの変動考えるのめんどくさいから先月返したことにする
        foreach ($product_ids as $product_id) {
            $product_deals_array[] = [
                'product_id' => $product_id,
                'borrower_user_id' => $faker->randomElement($user_ids),
                'created_at' => Carbon::now()->subMonths(2),
                'returned_at' => Carbon::now()->subMonth()
            ];
        }
        //利用中
        foreach ($product_ids as $product_id) {
            $product_deals_array[] = [
                'product_id' => $product_id,
                'borrower_user_id' => $faker->randomElement($user_ids),
                'created_at' => Carbon::now(),
                'returned_at' => null
            ];
        }
       DB::table('product_deals')->insert($product_deals_array);
    }
}