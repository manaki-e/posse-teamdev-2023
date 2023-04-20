<?php

namespace Database\Seeders;

use App\Models\PointExchange;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PointExchangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $instance = new PointExchange();
        $faker = Faker::create();
        for ($i = 0; $i < 10; $i++) {
            $random_number = PointExchange::MULTIPLE_OF * $faker->numberBetween(1, 10);
            $instance->createPointExchange($random_number, $this->getRandomUserId());
        }
    }
    public function getRandomUserId()
    {
        $users = User::all();
        return $users->random()->id;
    }
}