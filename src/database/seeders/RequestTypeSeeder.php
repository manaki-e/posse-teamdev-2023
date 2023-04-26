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
            ['name' => '貸出依頼'],
            //イベント？勉強会？結局どっちにするんだっけ？
            ['name' => '勉強会依頼'],
        ];
        DB::table('request_types')->insert($request_types_array);
    }
}