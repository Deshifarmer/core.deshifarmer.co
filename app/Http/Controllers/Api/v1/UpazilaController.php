<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\UpazilaResource;
use App\Models\v1\Upazila;
use Illuminate\Http\Request;

class UpazilaController extends Controller
{

    public function index()
    {
       return UpazilaResource::collection(Upazila::all());
    }


    public function show($district)
    {
        $upazilas = Upazila::where('district_id', $district)->get();
        return UpazilaResource::collection($upazilas);
    }


}
