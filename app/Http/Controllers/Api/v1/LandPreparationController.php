<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\v1\LandPreparation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LandPreparationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return LandPreparation::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'batch_id' => 'required|exists:batches,batch_id',
            'images' => 'required',
            'land_preparation_date' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $input = $request->only([
            'batch_id',
            'land_preparation_date',
            'images',
            'details',
        ]);
        if ($request->hasFile('images')) {
            $images = collect($request->file('images'))->map(function ($image, $key) {
                $extension = $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('public/farm/activity', $key . time() . '.' . $extension);
                return 'farm/activity/' . $key . time() . '.' . $extension;
            })->toArray();

            $input['images'] = $images;
        }

        LandPreparation::create($input);
        return response()->json([
            "message" => "Land Preparation created Successfully",
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(LandPreparation $landPreparation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LandPreparation $landPreparation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LandPreparation $landPreparation)
    {
        //
    }
}
