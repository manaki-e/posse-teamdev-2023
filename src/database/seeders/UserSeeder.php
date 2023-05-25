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
                'name' => '管理者1',
                'display_name' => '管理者',
                'email' => 'manaki@anti-pattern.co.jp',
                'password' => Hash::make('password'),
                'icon' => 'https://avatars.slack-edge.com/2023-05-10/5264743457040_ac27bba61b8057355862_512.jpg',
                'created_at' => now(),
                'updated_at' => now(),
                'slackID' => $this->slackUserId(),
                'is_admin' => 1,
                'department_id' => 1,
            ],
            [
                'name' => '管理者2',
                'display_name' => '管理者',
                'email' => 'manaki_nhk@keio.jp',
                'password' => Hash::make('password'),
                'icon' => 'https://avatars.slack-edge.com/2023-05-10/5264743457040_ac27bba61b8057355862_512.jpg',
                'created_at' => now(),
                'updated_at' => now(),
                'slackID' => $this->slackUserId(),
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
