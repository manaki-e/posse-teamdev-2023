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
            ],
            [
                // 一般ユーザー
                'name' => '一般User',
                'display_name' => '一般User',
                'email' => 'user_1@peerperk.com',
                'password' => Hash::make('password'),
                'icon' => 'https://ca.slack-edge.com/T014Y0DTWGN-U039L5786UU-ga51ce7481a2-512.jpg',
                'is_admin' => 0,
                'department_id' => 4,
            ],
            [
                // 一般ユーザー
                'name' => '一般ユーザー',
                'display_name' => '一般ユーザー',
                'email' => 'user_2@peerperk.com',
                'password' => Hash::make('password'),
                'icon' => 'https://ca.slack-edge.com/T057SBPTR24-U05D2QLDXA8-g24c61da1b43-512.jpg',
                'is_admin' => 0,
                'department_id' => 5,
            ],
            [
                // adminユーザー
                'name' => '管理者User',
                'display_name' => '管理者User',
                'email' => 'admin_1@peerperk.com',
                'password' => Hash::make('password'),
                'icon' => 'https://ca.slack-edge.com/T014Y0DTWGN-U049BLJUAHL-g078b5c7478d-512.jpg',
                'is_admin' => 1,
                'department_id' => 2,
            ],
            [
                // adminユーザー
                'name' => '管理者ユーザー',
                'display_name' => '管理者ユーザー',
                'email' => 'admin_2@peerperk.com',
                'password' => Hash::make('password'),
                'icon' => 'https://ca.slack-edge.com/T014Y0DTWGN-U049J61VDEF-g45fbaea1c1b-512.jpg',
                'is_admin' => 1,
                'department_id' => 1,
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
