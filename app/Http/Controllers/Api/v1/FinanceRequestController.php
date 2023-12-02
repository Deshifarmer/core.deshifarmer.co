<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\FinanceRequest;
use App\Http\Resources\v1\FinanceRequestResource;
use App\Models\v1\RequestFinance;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class FinanceRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fr = RequestFinance::latest()->paginate(25);
        return FinanceRequestResource::collection($fr);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FinanceRequest $request)
    {
        $input = $request->validated();
        RequestFinance::create($input);
        return response()->json(
            [
                'message' => "Request Recorded"
            ],
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(RequestFinance $requestFinance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RequestFinance $requestFinance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RequestFinance $requestFinance)
    {
        //
    }
}
