<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\v1\Farm;
use App\Models\v1\Farmer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FarmController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Farm::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $paths = [];
        $data['farm_id'] = 'Farm-' . $this->generateUUID();
        if ($request->has('gallery')) {

            $gallery = $request->gallery;
            foreach ($gallery as $key => $image) {
                $extension = $image->getClientOriginalExtension();
                $image->storeAs('public/farm/gallery', $key . $data['farm_id'] . '.' . $extension);
                $imagePath = 'farm/gallery/' . $key . $data['farm_id'] . '.' . $extension;

                $paths[] = $imagePath;
            }
        }
        $data['gallery'] = $paths;


        $farm = Farm::create($data);
        return response()->json([
            "message" => "Farm created Successfully",
            $farm
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Farm $farm)
    {
        return $farm;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Farm $farm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Farm $farm)
    {
        //
    }
    public function farmer_farm(Farmer $farmer)
    {
       return Farm::where('farmer_id', $farmer->farmer_id)->get();
    }



}
