<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductLikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $product_ids = Product::getProductIds();
        $user_ids = User::getUserIds();
        $user_id_count = count($user_ids);
        foreach ($product_ids as $product_id) {
            $random_user_ids = $faker->randomElements($user_ids, $faker->numberBetween(0, $user_id_count));
            foreach ($random_user_ids as $user_id) {
                $product_likes_array[] = [
                    'product_id' => $product_id,
                    'user_id' => $user_id,
                ];
            }
        }
        DB::table('product_likes')->insert($product_likes_array);
    }
}