<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\v1\Sowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Sowing::all();

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'batch_id' => 'required|exists:batches,batch_id',
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }
        Sowing::create($request->all());
        return response()->json([
            'message' => 'Sowing created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sowing $sowing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sowing $sowing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sowing $sowing)
    {
        //
    }
}
