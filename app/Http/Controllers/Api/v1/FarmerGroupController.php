<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\v1\FarmerGroupResource;
use App\Models\v1\Farmer;
use App\Models\v1\FarmerGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FarmerGroupController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return FarmerGroup::all()->sortByDesc('created_at');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'farmer_group_name' => 'required|string|max:255|unique:farmer_groups',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'error' => $validator->errors()
                ],
                422
            );
        }

        $data = $request->all();
        $data['farmer_group_id'] = 'FG-' . $this->generateUUID();
        $data['group_manager_id'] = auth()->user()->df_id;
        if ($request->has('group_leader')) {
            (new FarmerController)->update(
                new Request(
                    [
                        'group_id' => $data['farmer_group_id'],
                    ]
                ),
                Farmer::where('farmer_id', $request->group_leader)->first());
        }
        $farmerGroup = FarmerGroup::create($data);
        return response()->json($farmerGroup, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(FarmerGroup $farmerGroup)
    {
        return FarmerGroupResource::make($farmerGroup);
    }

    public function assignFarmer(Request $request, FarmerGroup $farmerGroup)
    {
        if(Farmer::where('group_id', $farmerGroup->farmer_group_id)->count() >= 25){
            return response()->json([
                'message' => 'Group is Full',
                'status' => 'error',
            ], 422);
        }

        foreach ($request->list as $key => $value) {
           (new FarmerController)->update(
                new Request(
                    [
                        'group_id' => $farmerGroup->farmer_group_id,
                    ]
                ),
                Farmer::where('farmer_id', $value)->first()
            );
        return $farmerGroup->farmer_group_id;
        }
        return response()->json([
            'message' => 'Farmer Assign Successfully',
            'status' => 'success',
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FarmerGroup $farmerGroup)
    {
        $farmerGroup->update($request->all());
        return response()->json($farmerGroup, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FarmerGroup $farmerGroup)
    {
        //
    }

    public function myGroup()
    {
        $farmerGroup = FarmerGroup::where('group_manager_id', auth()->user()->df_id)->get()->sortByDesc('created_at');
        return FarmerGroupResource::collection($farmerGroup);
    }

    public function freeGroup()
    
    {
        $farmerGroup = FarmerGroup::where('group_manager_id', auth()->user()->df_id)->get()->sortByDesc('created_at');
        $farmerGroup = $farmerGroup->filter(function ($value, $key) {
            $test = Farmer::where('group_id', $value->farmer_group_id)->count();
            return $test < 25 ;
        });
        return FarmerGroupResource::collection($farmerGroup);
    }
}
