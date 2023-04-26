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
        $faker=Faker::create();
        $product_ids = Product::getApprovedProductIds();
        $user_ids = User::getUserIds();
        //返却済み
        foreach($product_ids as $product_id){
            $product_deals_array[] = [
                'product_id' => $product_id,
                'borrower_user_id' => $faker->randomElement($user_ids),
                //ポイントの変動考えるのめんどくさいから先月返したことにする
                'created_at'=>Carbon::now()->subMonths(2),
                'returned_at'=>Carbon::now()->subMonth()
            ];
        }
        //利用中

    }
}