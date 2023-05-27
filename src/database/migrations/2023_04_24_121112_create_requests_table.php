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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('user_id')->constrained('users');
            $table->string('description');
            $table->timestamp('completed_at')->default(null)->nullable();
            $table->integer('type_id');
            $table->timestamps();
            $table->softDeletes();
        });
        $requests_array = [
            [
                'title' => 'バッテリー',
                'description' => "現在使っているバッテリーが壊れてしまったため、\n購入したバッテリーが届くまで貸してほしいです。",
                'user_id' => 5,
                'type_id' => 1,
                'created_at' => '2023/05/25 20:26:02',
                'completed_at' => '2023/05/30 00:00:00'
            ],
            [
                'title' => 'PHPを語り合う会',
                'description' => "なかなかPHPに慣れなくて、\n熟練者の方に手助けをしてもらいたいです。",
                'user_id' => 2,
                'type_id' => 2,
                'created_at' => '2023/03/08 10:26:02',
                'completed_at' => null
            ],
            [
                'title' => 'Tailwind講座',
                'description' => "tailwind難しいですよね。\n詰まっているところがあるので、\n教えてもらいたいです。",
                'user_id' => 3,
                'type_id' => 2,
                'created_at' => '2023/05/05 11:54:00',
                'completed_at' => null
            ],
            [
                'title' => 'Macbook',
                'description' => "WindowsにしようかMacbookにしようか迷っていて、\n使い心地を確かめたいので一週間ほど借りたいです。",
                'user_id' => 5,
                'type_id' => 1,
                'created_at' => '2023/02/05 14:23:45',
                'completed_at' => '2023/02/05 20:23:45'
            ],
            [
                'title' => 'RUSTオンラインもくもく会',
                'description' => "OSについての理解を深めたいです！\n有識者さんよろしくお願いします！！",
                'user_id' => 5,
                'type_id' => 2,
                'created_at' => '2023/05/04 10:26:02',
                'completed_at' => null
            ],
            [
                'title' => 'Ruby on rails勉強会',
                'description' => "バックエンドを始めたばかりで、\n難しいことばかりです。\n普段Ruby on railsを使用している方に教えてもらいたいです。",
                'user_id' => 2,
                'type_id' => 2,
                'created_at' => '2023/04/01 10:00:00',
                'completed_at' => '2023/04/29 14:20:30'
            ],
            [
                'title' => 'Airpods Pro',
                'description' => "有線のイヤホンか無線のイヤホンか迷っています。\n3日ほど借りたいです。",
                'user_id' => 1,
                'type_id' => 1,
                'created_at' => '2023/04/12 10:26:02',
                'completed_at' => null
            ],
            [
                'title' => 'Logicool キーボード MX Mechanical 茶軸 KX850FT',
                'description' => "どうしても使ってみたくて。\n持ってるけど使っていない方いたりしませんか？",
                'user_id' => 4,
                'type_id' => 1,
                'created_at' => '2023/02/26 10:26:02',
                'completed_at' => '2023/02/28 20:20:22'
            ],
        ];

        DB::table('requests')->insert($requests_array);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests');
    }
};
