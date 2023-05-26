<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public $usedNames = [];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('ja_JP');
        DB::table('users')->insert([
            [
                'name' => '高梨 彩音 / Ayane Takahashi',
                'display_name' => 'あやね',
                'email' => 'manaki.endou@anti-pattern.co.jp',
                'password' => Hash::make('password'),
                'icon' => 'https://avatars.slack-edge.com/2023-05-10/5264743457040_ac27bba61b8057355862_512.jpg',
                'created_at' => now(),
                'updated_at' => now(),
                'slackID' => 'U056W35F71C',
                'is_admin' => 1,
                'department_id' => 2,
            ],
            [
                'name' => '井戸宗達/Ido Sohtatu',
                'display_name' => 'sohtatu ido',
                'email' => 'sohtatsu.ido@keio.jp',
                'password' => Hash::make('password'),
                'icon' => 'https://secure.gravatar.com/avatar/043535e31b28f2131d9f5111526d8aa3.jpg?s=512&d=https%3A%2F%2Fa.slack-edge.com%2Fdf10d%2Fimg%2Favatars%2Fava_0009-512.png',
                'created_at' => now(),
                'updated_at' => now(),
                'slackID' => 'U056N55T9AB',
                'is_admin' => 1,
                'department_id' => 1,
            ]
        ]);
        for ($i = 1; $i <= 50; $i++) {
            $unique_user_name = $this->unique_name($faker);
            $users_array[] = [
                'name' => $unique_user_name,
                'display_name' => $unique_user_name,
                'email' => 'user' . $i . '@anti-pattern.co.jp',
                'password' => Hash::make('password'),
                'icon' => 'https://avatars.slack-edge.com/2023-05-10/5264743457040_ac27bba61b8057355862_512.jpg',
                'created_at' => now(),
                'updated_at' => now(),
                'slackID' => 'U' . $this->slackUserId(),
                'department_id' => $faker->randomElement(Department::getDepartmentIds()),
            ];
        }
        DB::table('users')->insert($users_array);
    }
    public function slackUserId()
    {
        $prefix = 'U';
        $length = rand(9, 11);
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $prefix . $randomString;
    }
    public function unique_name($faker)
    {
        do {
            $name = $faker->name;
        } while (in_array($name, $this->usedNames));
        $this->usedNames[] = $name;
        return $name;
    }
}
