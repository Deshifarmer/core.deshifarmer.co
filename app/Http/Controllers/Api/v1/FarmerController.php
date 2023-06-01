<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Resources\v1\FarmerResource;
use App\Models\v1\Farmer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FarmerController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return FarmerResource::collection(Farmer::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nid' => 'required|string|unique:farmers,nid',
            'phone' => 'required|unique:farmers'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        $data = $request->all();
        $data['farmer_id'] = 'far-' . $this->generateUUID();
        $data['input_by'] = auth()->user()->df_id;
        $extension = $request->file('image')->getClientOriginalExtension();
        $request->file('image')->storeAs('public/image/farmer', $data['farmer_id'] . '.' . $extension);
        $image_path = '/image/farmer/' . $data['farmer_id'] . '.' . $extension;
        $data['image'] =  $image_path;
        $farmer = Farmer::create($data);
        return new FarmerResource($farmer);
    }

    /**
     * Display the specified resource.
     */
    public function show(Farmer $farmer)
    {
        return new FarmerResource($farmer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Farmer $farmer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Farmer $farmer)
    {
        //
    }
}
