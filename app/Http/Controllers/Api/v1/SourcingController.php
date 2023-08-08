<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\SourcingResource;
use App\Models\v1\Sourcing;
use Illuminate\Http\Request;


class SourcingController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return SourcingResource::collection(Sourcing::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $paths = [];
        $data['source_id'] = 'Source-' . $this->generateUUID();

        $product_image = $request->product_image;
        foreach ($product_image as $key => $image) {
            $extension = $image->getClientOriginalExtension();
            $image->storeAs('public/image/sourcing/', $key . $data['source_id'] . '.' . $extension);
            $imagePath = '/image/sourcing/' . $key . $data['source_id'] . '.' . $extension;

            $paths[] = $imagePath;
        }
        $data['source_by'] = auth()->user()->id;
        $data['product_image'] = $paths;
        Sourcing::create($data);

        return response()->json([
            'message' => 'Sourcing created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sourcing $sourcing)
    {
        return SourcingResource::make($sourcing);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sourcing $sourcing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sourcing $sourcing)
    {
        //
    }
}
