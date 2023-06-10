<?php

namespace Database\Seeders;


//use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\v1\Upazila;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    // /**
    //  * Run the database seeds.
    //  */
    public function run(): void
    {
        User::truncate();

        $json = File::get('database/User.json');
        $users = json_decode($json);
        foreach ($users as $key => $value) {
            User::create([
                "df_id" => $value->df_id,
                "first_name" => $value->first_name,
                "last_name" => $value->last_name,
                'email' => $value->email,
                'phone' => $value->phone,
                'nid' => $value->nid,
                'password' => Hash::make('password'),
                'role' => $value->role,
            ]);
        }
    }
}
