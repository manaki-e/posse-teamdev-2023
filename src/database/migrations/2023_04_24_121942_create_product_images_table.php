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
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->string('image_url');
            $table->timestamps();
            $table->softDeletes();
        });

        $product_images_array = [
            //macbook 1
            ['product_id' => 1, 'image_url' => 'sample_product_3.jpeg'],
            //logicool mouse 2
            ['product_id' => 2, 'image_url' => 'logicool_mouse.jpg'],
            //logicool 3
            ['product_id' => 3, 'image_url' => 'LogicoolキーボードMXMechanical茶軸KX850FT2(1).jpg'],
            ['product_id' => 3, 'image_url' => 'LogicoolキーボードMXMechanical茶軸KX850FT2(2).jpg'],
            ['product_id' => 3, 'image_url' => 'LogicoolキーボードMXMechanical茶軸KX850FT2(3).jpg'],
            //airpods 4
            ['product_id' => 4, 'image_url' => 'AirbodsPro(1).jpg'],
            ['product_id' => 4, 'image_url' => 'AirbodsPro(2).jpg'],
            ['product_id' => 4, 'image_url' => 'AirbodsPro(3).jpg'],
            ['product_id' => 4, 'image_url' => 'AirbodsPro(4).jpg'],
            ['product_id' => 4, 'image_url' => 'AirbodsPro(5).jpg'],
            ['product_id' => 4, 'image_url' => 'AirbodsPro(6).jpg'],
            ['product_id' => 4, 'image_url' => 'AirbodsPro(7).jpg'],
            ['product_id' => 4, 'image_url' => 'AirbodsPro(8).jpg'],
            ['product_id' => 4, 'image_url' => 'AirbodsPro(9).jpg'],
            //anker727 5
            ['product_id' => 5, 'image_url' => 'アンカー(ANKER)Anker727ChargingStationA9126NF1(1).jpg'],
            ['product_id' => 5, 'image_url' => 'アンカー(ANKER)Anker727ChargingStationA9126NF1(2).jpg'],
            ['product_id' => 5, 'image_url' => 'アンカー(ANKER)Anker727ChargingStationA9126NF1(3).jpg'],
            //flexispot 6
            ['product_id' => 6, 'image_url' => 'FlexiSpotE7(1).jpg'],
            ['product_id' => 6, 'image_url' => 'FlexiSpotE7(2).jpg'],
            ['product_id' => 6, 'image_url' => 'FlexiSpotE7(3).jpg'],
            ['product_id' => 6, 'image_url' => 'FlexiSpotE7(4).jpg'],
            ['product_id' => 6, 'image_url' => 'FlexiSpotE7(5).jpg'],
            ['product_id' => 6, 'image_url' => 'FlexiSpotE7(6).jpg'],
            //anker511 7
            ['product_id' => 7, 'image_url' => 'アンカー(ANKER)Anker511PowerBankA1633N13.jpg'],
            //satechi 8
            ['product_id'=>8,'image_url'=>'Satechiデュアルバーティカルスタンド(1).jpg'],
            ['product_id'=>8,'image_url'=>'Satechiデュアルバーティカルスタンド(2).jpg'],
            ['product_id'=>8,'image_url'=>'Satechiデュアルバーティカルスタンド(3).jpg'],
            ['product_id'=>8,'image_url'=>'Satechiデュアルバーティカルスタンド(4).jpg'],
            //Shokz OpenRun Pro 9
            ['product_id'=>9,'image_url'=>'ShokzOpenRunPro.jpg'],
            //galaxy watch 10
            ['product_id'=>10,'image_url'=> 'サムスン(Samsung)GalaxyWatch5SM-R900NZAAXJP(1).jpg'],
            ['product_id'=>10,'image_url'=> 'サムスン(Samsung)GalaxyWatch5SM-R900NZAAXJP(2).jpg'],
            ['product_id'=>10,'image_url'=> 'サムスン(Samsung)GalaxyWatch5SM-R900NZAAXJP(3).jpg'],
        ];

        DB::table('product_images')->insert($product_images_array);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_images');
    }
};
