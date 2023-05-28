<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags_array = [
            ['request_type_id' => '1', 'name' => 'PC'],
            ['request_type_id' => '1', 'name' => 'モニター'],
            ['request_type_id' => '1', 'name' => 'キーボード'],
            ['request_type_id' => '1', 'name' => 'マウス'],
            ['request_type_id' => '1', 'name' => 'ヘッドセット'],
            ['request_type_id' => '1', 'name' => 'マイク'],
            ['request_type_id' => '1', 'name' => 'スピーカー'],
            ['request_type_id' => '1', 'name' => 'カメラ'],
            ['request_type_id' => '1', 'name' => 'ハードディスク'],
            ['request_type_id' => '1', 'name' => 'USBメモリ'],
            ['request_type_id' => '1', 'name' => '充電器'],
            ['request_type_id' => '1', 'name' => 'ケーブル'],
            ['request_type_id' => '1', 'name' => 'モバイルバッテリー'],
            ['request_type_id' => '1', 'name' => 'その他周辺機器'],
            ['request_type_id' => '1', 'name' => 'ノートPC'],
            ['request_type_id' => '1', 'name' => 'タブレット'],
            ['request_type_id' => '1', 'name' => 'スマートフォン'],
            ['request_type_id' => '2', 'name' => '勉強会'],
            ['request_type_id' => '2', 'name' => 'PHP'],
            ['request_type_id' => '2', 'name' => 'MySQL'],
            ['request_type_id' => '2', 'name' => 'Laravel'],
            ['request_type_id' => '2', 'name' => 'JavaScript'],
            ['request_type_id' => '2', 'name' => 'React'],
            ['request_type_id' => '2', 'name' => 'Vue'],
            ['request_type_id' => '2', 'name' => 'Node.js'],
            ['request_type_id' => '2', 'name' => 'Python'],
            ['request_type_id' => '2', 'name' => 'Django'],
            ['request_type_id' => '2', 'name' => 'Ruby'],
            ['request_type_id' => '2', 'name' => 'Ruby on Rails'],
            ['request_type_id' => '2', 'name' => 'Java'],
            ['request_type_id' => '2', 'name' => 'C#'],
            ['request_type_id' => '2', 'name' => 'C++'],
            ['request_type_id' => '2', 'name' => 'C'],
            ['request_type_id' => '2', 'name' => 'ゲーム大会'],
            ['request_type_id' => '2', 'name' => 'バーベキュー'],
            ['request_type_id' => '2', 'name' => 'カラオケ大会'],
            ['request_type_id' => '2', 'name' => '飲み会'],
            ['request_type_id' => '2', 'name' => '社内運動会'],
            ['request_type_id' => '2', 'name' => 'スポーツ観戦'],
            ['request_type_id' => '2', 'name' => 'シャッフルランチ'],
            ['request_type_id' => '2', 'name' => 'クイズゲーム'],
            ['request_type_id' => '2', 'name' => 'ボウリング大会'],
        ];
        DB::table('tags')->insert($tags_array);
    }
}
