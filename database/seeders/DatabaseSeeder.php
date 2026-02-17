<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            BrandSeeder::class,
            UsersSeeder::class,
            SkinTypeSeeder::class,
            ConcernSeeder::class,
            ProductTypeSeeder::class,
            TestSeeder::class,
            ProductSeeder::class,
            RoutineTypeSeeder::class,
            RoutineNeedSeeder::class,
            RoutineSeeder::class,
            RoutineTimeSeeder::class,
            BlogSeeder::class,
        ]);
    }

}
