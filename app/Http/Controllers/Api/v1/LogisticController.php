<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\v1\Logistic;
use Illuminate\Http\Request;

class LogisticController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return Logistic::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['log_id'] = $this->generateId();
        $input['request_by'] = auth()->user()->df_id;
        Logistic::create($input);

        return response()->json([
            'success' => true,
            'message' => 'Logistic created successfully'
        ], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(Logistic $logistic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Logistic $logistic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Logistic $logistic)
    {
        //
    }
}
