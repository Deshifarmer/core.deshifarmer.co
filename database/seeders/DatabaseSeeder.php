<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\v1\District;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DivisionsSeeder::class,
            DistrictsSeeder::class,
            UpazilasSeeder::class,
            UnitSeeder::class,
            UserSeeder::class,
            EmployeeSeeder::class,
            EmployeeAccSeeder::class,
        ]);
    }
}
