<?php

namespace Database\Seeders;


//use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\v1\Employee;
use App\Models\v1\Upazila;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    // /**
    //  * Run the database seeds.
    //  */
    public function run(): void
    {
        Employee::truncate();

        $json = File::get('database/employee.json');
        $users = json_decode($json);
        foreach ($users as $key => $value) {
            Employee::create([

                "df_id"=> $value->df_id,
                "first_name"=>  $value->first_name,
                "last_name"=> $value->last_name,
                "email"=>  $value->email,
                "phone"=>  $value->phone,
                "nid"=>  $value->nid,
                "type"=> $value->type,
                "status" =>  $value->status,
                "onboard_by"=>  $value->onboard_by,
            ]);
        }
    }
}
