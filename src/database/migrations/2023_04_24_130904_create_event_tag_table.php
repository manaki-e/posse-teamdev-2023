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
            //PHP勉強会
            ['event_id' => 1, 'tag_id' => 11],
            ['event_id' => 1, 'tag_id' => 22],
            //tailwind勉強会
            ['event_id' => 2, 'tag_id' => 20],
            ['event_id' => 2, 'tag_id' => 22],
            //goodcodebadcode勉強会
            ['event_id' => 3, 'tag_id' => 22],
            //react勉強会
            ['event_id' => 4, 'tag_id' => 22],
            ['event_id' => 4, 'tag_id' => 23],
            //rubyrails勉強会もくもく
            ['event_id' => 5, 'tag_id' => 16],
            ['event_id' => 5, 'tag_id' => 22],
            ['event_id' => 5, 'tag_id' => 21],
            //rustもくもく
            ['event_id' => 6, 'tag_id' => 21],
            //AI勉強会
            ['event_id' => 7, 'tag_id' => 17],
            ['event_id' => 7, 'tag_id' => 22],
            //もくもく 
            ['event_id' => 8, 'tag_id' => 21],
            //セキュリティ
            ['event_id' => 9, 'tag_id' => 18],
            ['event_id' => 9, 'tag_id' => 22],
            //redmine
            ['event_id' => 10, 'tag_id' => 22],
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
