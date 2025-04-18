<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\BatchResource;
use App\Models\v1\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BatchController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return BatchResource::collection(Batch::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'season' => 'required|string',
            'farm_id' => 'required|string|exists:farms,farm_id',
            'which_crop' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $input = $request->all();
        $input['batch_id'] = 'B-' . $this->generateUUID();
        $input['created_by'] = auth()->user()->df_id;
        $batch = Batch::create($input);
        return response()->json(
            BatchResource::make($batch),
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Batch $batch)
    {
        return BatchResource::make($batch);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Batch $batch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Batch $batch)
    {
        //
    }

    public function farmBatch()
    {
        $validator = Validator::make(Request()->all(), [
            'farm_id' => 'required|string|exists:farms,farm_id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $farm_id = Request()->farm_id;

        $batches = Batch::where('farm_id', $farm_id)
            // ->where('created_by', auth()->user()->df_id)
            ->latest()
            ->get();
        return BatchResource::collection($batches);
    }

    public function my_batch(){
        $batches = Batch::where('created_by', auth()->user()->df_id)
            ->latest()
            ->get();
        return BatchResource::collection($batches);
    }
}
