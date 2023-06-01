<?php

namespace Database\Seeders;


//use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\v1\District;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\File;

class DistrictsSeeder extends Seeder
{
    // /**
    //  * Run the database seeds.
    //  */
    public function run(): void
    {
        District::truncate();

        $json = File::get('database/districts.json');
        $locations = json_decode($json);
        foreach ($locations as $key => $value) {
            District::create([
                "division_id" => $value->division_id,
                "name" => $value->name,
                "bn_name" => $value->bn_name,
                "lat" => $value->lat,
                "long" => $value->long,
            ]);
        }
    }
}
