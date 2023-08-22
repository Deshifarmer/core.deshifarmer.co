<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\ActivityResource;
use App\Models\v1\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Activity::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $images = [];
        if ($request->hasFile('images')) {
            $gallery = $request->images;
            foreach ($gallery as $key => $image) {
                $extension = $image->getClientOriginalExtension();
                $image->storeAs('public/farm/activity', $key . time() . '.' . $extension);
                $imagePath = 'farm/activity/' . $key . time() . '.' . $extension;

                $images[] = $imagePath;
            }
            $input['images'] = json_encode($images);
        }
        $input['activity_by'] = auth()->user()->df_id;
        $activity = Activity::create($input);
        return response()->json([
            "message" => "Activity created Successfully",
            'activity' => $activity
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Activity $activity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Activity $activity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        //
    }

    public function myRecordedActivities()
    {
        $activities = ActivityResource::collection(Activity::where('activity_by', auth()->user()->df_id)->get());

        return response()->json(
             $activities
        , 200);
    }
}
