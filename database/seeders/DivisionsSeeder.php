<?php

namespace Database\Seeders;


//use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\v1\District;
use App\Models\v1\Division;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\File;

class DivisionsSeeder extends Seeder
{
    // /**
    //  * Run the database seeds.
    //  */
    public function run(): void
    {
        Division::truncate();

        $json = File::get('database/divisions.json');
        $locations = json_decode($json);
        foreach ($locations as $key => $value) {
            Division::create([
                "name" => $value->name,
                "bn_name" => $value->bn_name,
                "lat" => $value->lat,
                "long" => $value->long,
            ]);
        }
    }
}
