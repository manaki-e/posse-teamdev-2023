<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('request_type_id');
            $table->timestamps();
            $table->softDeletes();
        });

        $tags_array = [
            ['request_type_id' => '1', 'name' => 'モニター'],
            ['request_type_id' => '1', 'name' => 'リモートワーク'],
            ['request_type_id' => '1', 'name' => 'キーボード'],
            ['request_type_id' => '1', 'name' => 'マウス'],
            ['request_type_id' => '1', 'name' => 'イヤホン'],
            ['request_type_id' => '1', 'name' => 'デスク'],
            ['request_type_id' => '1', 'name' => 'スタンド'],
            ['request_type_id' => '1', 'name' => 'ヘルスケア'],
            ['request_type_id' => '1', 'name' => '充電器'],
            ['request_type_id' => '1', 'name' => 'ケーブル'],
            ['request_type_id' => '1', 'name' => 'モバイルバッテリー'],
            ['request_type_id' => '1', 'name' => 'PC'],
            ['request_type_id' => '1', 'name' => 'タブレット'],
            ['request_type_id' => '2', 'name' => 'PHP'],
            ['request_type_id' => '2', 'name' => 'MySQL'],
            ['request_type_id' => '2', 'name' => 'JavaScript'],
            ['request_type_id' => '2', 'name' => 'Python'],
            ['request_type_id' => '2', 'name' => 'Django'],
            ['request_type_id' => '2', 'name' => 'Ruby'],
            ['request_type_id' => '2', 'name' => 'AI'],
            ['request_type_id' => '2', 'name' => 'セキュリティ'],
            ['request_type_id' => '2', 'name' => 'NoSQL'],
            ['request_type_id' => '2', 'name' => 'Tailwind'],
            ['request_type_id' => '2', 'name' => 'もくもく会'],
            ['request_type_id' => '2', 'name' => '勉強会'],
            ['request_type_id' => '2', 'name' => 'React'],
            ['request_type_id' => '2', 'name' => '飲み会'],
            ['request_type_id' => '2', 'name' => 'シャッフルランチ'],
        ];
        DB::table('tags')->insert($tags_array);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags');
    }
};
