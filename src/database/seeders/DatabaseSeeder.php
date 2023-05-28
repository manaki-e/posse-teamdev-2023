<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            DepartmentSeeder::class,
            UserSeeder::class,
            PointExchangeLogSeeder::class,
            TagSeeder::class,
            RequestSeeder::class,
            RequestTagSeeder::class,
            RequestLikeSeeder::class,
            ProductSeeder::class,
            ProductTagSeeder::class,
            ProductImageSeeder::class,
            ProductLikeSeeder::class,
            ProductDealLogSeeder::class,
            EventSeeder::class,
            EventParticipantLogSeeder::class,
            EventLikeSeeder::class,
            EventTagSeeder::class,
        ]);
    }
}