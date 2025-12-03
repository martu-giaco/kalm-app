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
        ProductTypeSeeder::class,
        ProductCategorySeeder::class,
        BrandSeeder::class,
        ProductSeeder::class,
        RoutineTypeSeeder::class,
        RoutineTimeSeeder::class,
    ]);
}

}
