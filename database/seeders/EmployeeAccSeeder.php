<?php

namespace Database\Seeders;


//use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\v1\Employee;
use App\Models\v1\EmployeeAccount;
use App\Models\v1\Upazila;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class EmployeeAccSeeder extends Seeder
{
    // /**
    //  * Run the database seeds.
    //  */
    public function run(): void
    {
        EmployeeAccount::truncate();

        $json = File::get('database/employeeAcc.json');
        $users = json_decode($json);
        foreach ($users as $key => $value) {
            EmployeeAccount::create([
              "acc_number"=> $value->acc_number,
            ]);
        }
    }
}
