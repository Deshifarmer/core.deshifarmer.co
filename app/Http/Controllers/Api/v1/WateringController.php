<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\v1\Watering;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WateringController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Watering::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'batch_id' => 'required|string|exists:batches,batch_id',

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
         Watering::create($request->all());
         return response()->json([
             'message' => 'Watering record created successfully'
         ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Watering $watering)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Watering $watering)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Watering $watering)
    {
        //
    }
}
