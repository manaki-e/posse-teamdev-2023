<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ProductStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product_statuses_array=[
            ['name'=>'申請中'],
            ['name'=>'利用可能'],
            ['name'=>'利用中']
        ];
        DB::table('product_statuses')->insert($product_statuses_array);
    }
}