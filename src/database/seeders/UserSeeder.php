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
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        DB::table('users')->insert([
            'name' => '管理者',
            'email' => env('ADMIN_EMAIL_ADDRESS'),
            'password' => Hash::make(env('ADMIN_PASSWORD')),
            'created_at' => now(),
            'updated_at' => now(),
            'slack' => env('ADMIN_SLACK_ID'),
            'admin_bool' => 1,
            'department_id' => 1,
        ]);
        for ($i = 0; $i < 50; $i++) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->freeEmail . env('ALLOWED_EMAIL_DOMAIN'),
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
                'slack' => 'U' . $this->slackUserId(),
                'department_id' => $faker->randomElement(Department::getDepartmentIds()),
            ]);
        }
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
}