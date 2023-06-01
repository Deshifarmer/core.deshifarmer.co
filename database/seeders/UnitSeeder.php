<?php

namespace Database\Seeders;


//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\v1\Unit;

use Illuminate\Support\Facades\File ;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Unit::truncate();

        $json =File::get('database/unit.json');
        $units=json_decode($json);
        foreach ($units as $key => $value) {
            Unit::create([
                "unit" => $value->unit,
            ]);
        }
    }
}

//php artisan db:seed --class=UnitSeeder
