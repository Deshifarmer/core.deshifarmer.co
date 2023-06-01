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
        ],[
            'df_id' => 'CO-02',
            'first_name' => "Company",
            'last_name' => "one",
            'email' => 'company@gmail.com',
            'phone' => '0170000000',
            'nid'=>'123456789012345',
            'role' => 1,
            'password' => Hash::make('password'),
        ]
        ,[
            'df_id' => 'DB-03',
            'first_name' => "Distributor",
            'last_name' => "one",
            'email' => 'distributor@gmail.com',
            'phone' => '01700000001',
            'nid'=>'12345678901234',
            'role' => 1,
            'password' => Hash::make('password'),
        ]
        ,[
            'df_id' => 'ME-04',
            'first_name' => "Micro",
            'last_name' => "one",
            'email' => 'me@gmail.com',
            'phone' => '01700000002',
            'nid'=>'123456789012349',
            'role' => 1,
            'password' => Hash::make('password'),
        ]
    );
    }
}
