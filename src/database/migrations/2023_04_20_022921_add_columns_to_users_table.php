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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('earned_point')->default(0);
            $table->integer('remaining_point')->default(5000);
            $table->boolean('admin_bool')->default(0);
            $table->string('slack');
            $table->foreignId('department_id')->constrained('departments');
            $table->softDeletes();
        });
        // slackからユーザー一斉に追加する機能実装するときはここに書く想定
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};