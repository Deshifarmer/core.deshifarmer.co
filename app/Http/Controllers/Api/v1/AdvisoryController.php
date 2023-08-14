<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\v1\Advisory;
use Illuminate\Http\Request;

class AdvisoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Advisory::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        
    }

    /**
     * Display the specified resource.
     */
    public function show(Advisory $advisory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Advisory $advisory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advisory $advisory)
    {
        //
    }
}
