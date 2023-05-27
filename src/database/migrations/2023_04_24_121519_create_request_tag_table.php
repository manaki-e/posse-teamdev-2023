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
            // バッテリー
            ['request_id' => 1, 'tag_id' => 12],
            // PHP
            ['request_id' => 2, 'tag_id' => 15],
            // tailwindタグなし
            //macbook
            ['request_id' => 4, 'tag_id' => 13],
            //rustはタグなし
            //ruby on rails
            ['request_id' => 6, 'tag_id' => 20],
            // airpods
            ['request_id' => 7, 'tag_id' => 4],
            //キーボード
            ['request_id' => 8, 'tag_id' => 2],
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
