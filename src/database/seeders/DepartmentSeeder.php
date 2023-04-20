<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            ['name' => '総務部'],
            ['name' => '人事部'],
            ['name' => '経理部'],
            ['name' => '営業部'],
            ['name' => '開発部'],
            ['name' => 'デザイン部'],
            ['name' => 'マーケティング部'],
            ['name' => '企画部'],
            ['name' => '研究開発部'],
        ]);
    }
}