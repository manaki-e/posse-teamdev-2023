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
        Schema::create('request_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained('requests');
            $table->foreignId('tag_id')->constrained('tags');
            $table->timestamps();
            $table->softDeletes();
        });

        $request_tag_array = [
            // バッテリータグなし
            //PHP勉強会
            ['request_id' => 2, 'tag_id' => 11],
            ['request_id' => 2, 'tag_id' => 22],
            //tailwind勉強会
            ['request_id' => 3, 'tag_id' => 20],
            ['request_id' => 3, 'tag_id' => 22],
            //macbook
            ['request_id' => 4, 'tag_id' => 9],
            //rustもくもく
            ['request_id' => 5, 'tag_id' => 21],
            //rubyrails勉強会もくもく
            ['request_id' => 6, 'tag_id' => 16],
            ['request_id' => 6, 'tag_id' => 21],
            ['request_id' => 6, 'tag_id' => 22],
            // airpods
            ['request_id' => 7, 'tag_id' => 5],
            //キーボード
            ['request_id' => 8, 'tag_id' => 3],
        ];
        DB::table('request_tag')->insert($request_tag_array);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_tag');
    }
};
