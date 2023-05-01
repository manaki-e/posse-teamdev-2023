<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Request;
use App\Models\Tag;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $tag_instance = new Tag();
        $product_tags = $tag_instance->getIdsByRequestTypeId(Request::PRODUCT_REQUEST_TYPE_ID);
        $product_ids = Product::getProductIds();
        foreach ($product_ids as $product_id) {
            $tag_count = $faker->numberBetween(0, 2);
            $random_product_tags = $faker->randomElements($product_tags, $tag_count);
            foreach ($random_product_tags as $random_product_tag) {
                $product_tags_array[] = [
                    'product_id' => $product_id,
                    'tag_id' => $random_product_tag,
                ];
            }
        }
        DB::table('product_tag')->insert($product_tags_array);
    }
}