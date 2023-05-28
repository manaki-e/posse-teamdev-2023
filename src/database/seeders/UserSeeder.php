<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Http\Controllers\SlackController;
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
