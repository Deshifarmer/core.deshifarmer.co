<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\UpazilaResource;
use App\Models\v1\upazila;
use Illuminate\Http\Request;

class UpazilaController extends Controller
{

    public function index()
    {
       return UpazilaResource::collection(upazila::all());
    }


    public function show($district)
    {
        $upazilas = upazila::where('district_id', $district)->get();
        return UpazilaResource::collection($upazilas);
    }


}
