<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Product;
use App\Models\ProductDeal;
use App\Models\User;
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
        $product_ids = Product::getProductIds();
        $user_ids = User::getUserIds();
        //返却済み
        foreach($product_ids as $product_id){
            $product_deals_array[] = [
                'product_id' => $product_id,
                'user_id' => $user_ids[array_rand($user_ids)],
                'status' => 0,
                'created_at'=>now(),
            ];
        }
        //利用中
    }
}
