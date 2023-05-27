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
        Schema::create('product_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('tag_id')->constrained('tags')->where('request_type_id', '=', '1');
            $table->timestamps();
            $table->softDeletes();
        });

        $product_tags_array = [
            ///macbook 1
            ['product_id' => 1, 'tag_id' => 13],
            //logicool mouse 2
            ['product_id' => 2, 'tag_id' => 3],
            //logicool 3
            ['product_id' => 3, 'tag_id' => 2],
            //airpods 4
            ['product_id' => 4, 'tag_id' => 4],
            //anker727 5
            ['product_id' => 5, 'tag_id' => 10],
            //flexispot 6
            ['product_id' => 6, 'tag_id' => 5],
            //anker511 7
            ['product_id' => 7, 'tag_id' => 10],
            ['product_id' => 7, 'tag_id' => 12],
            //satechi 8
            ['product_id' => 8, 'tag_id' => 6],
            //Shokz OpenRun Pro 9
            ['product_id' => 9, 'tag_id' => 4],
            //galaxy watch 10
            ['product_id' => 10, 'tag_id' => 7],
        ];

        DB::table('product_tag')->insert($product_tags_array);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_tag');
    }
};
