<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\v1\CashInRequest;
use Illuminate\Http\Request;

class CashInRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return CashInRequest::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        if($request->hasFile('receipt')){

            $extension = $request->file('receipt')->getClientOriginalExtension();
            $request->file('receipt')->storeAs('public/image/cashinreq',time() . '.' . $extension);
            $image_path = '/image/cashinreq/' . time() . '.' . $extension;
        } else {
         $image_path= $request->receipt;
        }

        $data['receipt'] = $image_path;
        $data['df_id'] = auth()->user()->df_id;
        CashInRequest::create($data);
        return response()->json([
            'message' => 'Cash In Request Send Successfully',
            'status' => 'success',
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(CashInRequest $cashInRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CashInRequest $cashInRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CashInRequest $cashInRequest)
    {
        //
    }
}
