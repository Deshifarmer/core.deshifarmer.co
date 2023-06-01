<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\DistrictResource;
use App\Models\v1\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{

    public function index()
    {
       return DistrictResource::collection(District::all());
    }

    /**
     * Display the specified resource.
     */
    public function show($division)
    {
        $districts = District::where('division_id', $division)->get();
        return DistrictResource::collection($districts);
    }


}
