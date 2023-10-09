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
            $table->string('display_name')->nullable();
            $table->integer('earned_point')->default(0);
            $table->string('icon');
            $table->integer('distribution_point')->default(5000);
            $table->boolean('is_admin')->default(0);
            $table->foreignId('department_id')->nullable()->constrained('departments');
            $table->softDeletes();
        });

        DB::table('users')->insert([
            [
                'name' => '井戸宗達/Ido Sohtatu',
                'display_name' => 'sohtatu ido',
                'email' => 'sohtatsu.ido@keio.jp',
                'password' => Hash::make('password'),
                'icon' => 'https://avatars.slack-edge.com/2023-06-03/5361141931894_5135cf4f35851443dce9_512.jpg',
                'is_admin' => 1,
                'department_id' => 1,
            ],
            [
                //yuta
                'name' => '本城裕大 / Yuta Honjo',
                'display_name' => '本城先生',
                'email' => 'yutahonjo@keio.jp',
                'password' => Hash::make('password'),
                'icon' => 'https://avatars.slack-edge.com/2023-05-10/5253561557201_8877a441f0599a9a63c3_512.png',
                'is_admin' => 0,
                'department_id' => 5,
            ],
            [
                //manaki4869管理者
                'name' => '遠藤愛期 / Manaki Endo',
                'display_name' => 'まなき',
                'email' => '48690114s@gmail.com',
                'password' => Hash::make('password'),
                'icon' => 'https://avatars.slack-edge.com/2023-05-10/5264402931744_123cd38dcc55af7397e6_512.jpg',
                'is_admin' => 1,
                'department_id' => 2,
            ],
            [
                //yoshitaka
                'name' => '五十嵐佳貴 /Yoshitaka Igarashi',
                'display_name' => '15歳までまるこめ',
                'email' => 'm22y10m20.yoshikun@gmail.com',
                'password' => Hash::make('password'),
                'icon' => 'https://avatars.slack-edge.com/2023-05-23/5320682617089_b8913a0eb43d81b5acb8_512.jpg',
                'is_admin' => 0,
                'department_id' => null,
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            Schema::dropIfExists('users');
        });
    }
};
