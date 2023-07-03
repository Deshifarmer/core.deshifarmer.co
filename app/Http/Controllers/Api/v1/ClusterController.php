<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\v1\Cluster;
use Illuminate\Http\Request;

class ClusterController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Cluster::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['cluster_id'] = 'Clust-' . $this->generateUUID();
        $data['created_by'] = auth()->user()->id;
        Cluster::create($data);
        return response()->json([
            'message' => 'Cluster created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cluster $cluster)
    {
        return $cluster;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cluster $cluster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cluster $cluster)
    {
        //
    }
}
