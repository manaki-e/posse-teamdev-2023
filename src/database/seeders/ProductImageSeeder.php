<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
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
        $product_image_instance = new ProductImage();
        //メイン画像を作成
        foreach ($product_ids as $product_id) {
            $image_url = 'main' . $product_id . '.jpg';
            $product_images_array[] = [
                'product_id' => $product_id,
                'image_url' => $image_url,
            ];
            $product_image_instance->createImageAndSaveToPublicWithTextOverlay($image_url,'images/main/');
        }
        //サブ画像を作成
        foreach ($product_ids as $product_id) {
            //サブ画像の数をランダムに決定=>デザインの崩れの対策しやすくするため
            $number_of_sub_image_files=count(glob(public_path('images/sub/*')));
            $image_count = $faker->numberBetween(0, $number_of_sub_image_files);
            for ($i = 1; $i <= $image_count; $i++) {
                $image_url = 'sub_' . $i .'.jpg';
                $product_images_array[] = [
                    'product_id' => $product_id,
                    'image_url' => $image_url,
                ];
            }
        }
        DB::table('product_images')->insert($product_images_array);
    }
}