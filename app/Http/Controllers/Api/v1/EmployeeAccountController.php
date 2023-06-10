<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\v1\EmployeeAccount;
use Illuminate\Http\Request;

class EmployeeAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return EmployeeAccount::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeAccount $employeeAccount)
    {
        return $employeeAccount;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeAccount $employeeAccount)
    {
      return  $employeeAccount->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeAccount $employeeAccount)
    {
        //
    }
}
