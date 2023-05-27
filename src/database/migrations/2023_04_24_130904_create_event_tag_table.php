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
        Schema::create('event_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events');
            $table->foreignId('tag_id')->constrained('tags')->where('request_type_id', '=', '2');
            $table->timestamps();
            $table->softDeletes();
        });

        $event_tags_array = [
            //PHP
            ['event_id' => 1, 'tag_id' => 15],
            //tailwind
            ['event_id' => 2, 'tag_id' => 24],
            //goodcodebadcode
            ['event_id' => 3, 'tag_id' => 26],
            //react
            ['event_id' => 4, 'tag_id' => 27],
            //rubyrails
            ['event_id' => 5, 'tag_id' => 20],
            //rust
            ['event_id' => 6, 'tag_id' => 25],
            //AI
            ['event_id' => 7, 'tag_id' => 21],
            //もくもく
            ['event_id' => 8, 'tag_id' => 25],
            //セキュリティ
            ['event_id' => 9, 'tag_id' => 22],
            //redmine
            ['event_id' => 10, 'tag_id' => 26],
        ];
        DB::table('event_tag')->insert($event_tags_array);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_tag');
    }
};
