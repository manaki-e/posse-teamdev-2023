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
            PointExchangeSeeder::class,
            RequestTypeSeeder::class,
            TagSeeder::class,
            RequestSeeder::class,
            RequestTagSeeder::class,
            RequestLikeSeeder::class,
            ProductSeeder::class,
            ProductTagSeeder::class,
            ProductImageSeeder::class,
            ProductLikeSeeder::class,
            ProductDealSeeder::class,
            // PointLogSeeder::class,=>これは一番最後にやる(dealsとparticipantsの内容反映させるから)
        ]);
    }
}
