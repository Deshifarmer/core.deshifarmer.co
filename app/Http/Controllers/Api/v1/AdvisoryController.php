<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\v1\Advisory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $input = $request->all();
        if($request->hasFile('files')) {
            $paths = [];
            $files = $request->file('files');

            foreach ($files as $key => $image) {
                $extension = $image->getClientOriginalExtension();
                $image->storeAs('public/advisory', $key.time()  .'.'. $extension);
                $imagePath = 'advisory/' . $key.time()  .'.'. $extension;

                $paths[] = $imagePath;
            }
            $input['files'] = $paths;
        }

        $input['created_by'] = auth()->user()->df_id;

        $advisory = Advisory::create($input);
        return response()->json($advisory, 201);
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
