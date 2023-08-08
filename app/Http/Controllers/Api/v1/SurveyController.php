<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\v1\Employee;
use App\Models\v1\Survey;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return Survey::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->all();
        $data['me_id'] = auth()->user()->df_id;
        $data['cp_id'] = Employee::where('df_id', $data['me_id'])->get()->implode('under');
        $data['current_seed'] = json_encode($request->current_seed);
        $data['current_fertilizer'] = json_encode($request->current_seed);
        $data['current_pesticide'] = json_encode($request->current_seed);

        $data['future_seed'] = json_encode($request->future_seed);
        $data['future_fertilizer'] = json_encode($request->future_fertilizer);
        $data['future_pesticide'] = json_encode($request->future_pesticide);

        Survey::create($data);
        return response()->json([
            'message' => 'Survey created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Survey $survey)
    {
        return $survey;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Survey $survey)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Survey $survey)
    {
        //
    }
}
