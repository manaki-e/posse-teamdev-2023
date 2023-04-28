<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductImageSeeder extends Seeder
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
        foreach ($product_ids as $product_id) {
            $image_files=glob(public_path('images/*'));
            $image_count = $faker->numberBetween(1, 3);
            $image_array=$faker->randomElements($image_files,$image_count);
            foreach($image_array as $image){
                $image_filename=basename($image);
                $product_images_array[]=[
                    'product_id'=>$product_id,
                    'image_url'=>$image_filename,
                ];
            }
        }
        DB::table('product_images')->insert($product_images_array);
    }
}