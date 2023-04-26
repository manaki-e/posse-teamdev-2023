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
        for ($i = 1; $i <= 30; $i++) {
            $products_array[] = [
                'title' => 'アイテム'.$i,
                'point' => $faker->randomElement([null,$faker->randomElement([100, 200, 300, 400, 500])]),
                'description' => 'これはアイテム'.$i.'の備考です。',
                'product_status_id'=>$faker->randomElement(ProductStatus::getProductStatusIds()),
                'request_id'=>$faker->randomElement(Request::getRequestIds()),
                'user_id'=>$faker->randomElement(User::getUserIds()),
                'created_at' => now()
            ];
        }
        DB::table('products')->insert($products_array);
    }
}