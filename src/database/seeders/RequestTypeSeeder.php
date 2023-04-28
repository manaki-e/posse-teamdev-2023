<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RequestTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $request_types_array = [
            ['name' => 'アイテム'],
            ['name' => 'イベント'],
        ];
        DB::table('request_types')->insert($request_types_array);
    }
}