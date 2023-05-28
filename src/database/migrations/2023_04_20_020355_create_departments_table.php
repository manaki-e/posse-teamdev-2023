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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departments');
    }
};
