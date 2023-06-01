<?php

namespace Database\Seeders;


//use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\v1\Upazila;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\File;

class UpazilasSeeder extends Seeder
{
    // /**
    //  * Run the database seeds.
    //  */
    public function run(): void
    {
        Upazila::truncate();

        $json = File::get('database/upazilas.json');
        $locations = json_decode($json);
        foreach ($locations as $key => $value) {
            Upazila::create([
                "district_id" => $value->district_id,
                "name" => $value->name,
                "bn_name" => $value->bn_name,
            ]);
        }
    }
}
