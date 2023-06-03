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
        ]);
        DB::table('users')->insert([
            'df_id' => 'HQ-01',
            'first_name' => "Hasibur",
            'last_name' => "Rahman",
            'email' => 'shuvodfbe@gmail.com',
            'phone' => '01700000000',
            'nid'=>'12345678901234567',
            'role' => 0,
            'password' => Hash::make('password'),
        ]
    );
    }
}
