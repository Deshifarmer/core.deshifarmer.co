<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\v1\OutputCustomer;
use Illuminate\Http\Request;

class OutputCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return OutputCustomer::all();
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
    public function show(OutputCustomer $outputCustomer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OutputCustomer $outputCustomer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OutputCustomer $outputCustomer)
    {
        //
    }
}
