<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\CashInRequestResource;
use App\Models\v1\CashInRequest;
use App\Models\v1\EmployeeAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CashInRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CashInRequestResource::collection(CashInRequest::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
           'receipt_id' => 'required|unique:cash_in_requests,receipt_id',
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }

        $data = $request->all();

        if ($request->hasFile('receipt')) {
            $extension = $request->file('receipt')->getClientOriginalExtension();
            $request->file('receipt')->storeAs('public/image/cashinreq', time() . '.' . $extension);
            $image_path = '/image/cashinreq/' . time() . '.' . $extension;
            $data['receipt'] = $image_path;
        }


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
        return new CashInRequestResource($cashInRequest);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CashInRequest $cashInRequest)
    {
        $validator = Validator::make($request->all(), [
           'status' => 'required|in:approved,rejected',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        if ($cashInRequest->status == 'pending') {

            $employeeAccountDetails = EmployeeAccount::where('acc_number', $cashInRequest->df_id)->get(['net_balance', 'total_credit']);

            if($request->status == 'approved'){
                $OldNetBalance = $employeeAccountDetails->implode('net_balance');
                $oldTotalCredit =$employeeAccountDetails->implode('total_credit');
               (new EmployeeAccountController)->update(
                    new Request(
                        [
                           'net_balance' =>  floatval($OldNetBalance) + floatval($request->accepted_amount),
                           'total_credit' =>  floatval($oldTotalCredit) + floatval($request->accepted_amount),
                        ]
                    ),
                    EmployeeAccount::where('acc_number', $cashInRequest->df_id)->first()
                );

                (new TransactionController)->store(
                    new Request(
                        [
                            'amount' => $request->accepted_amount,
                            'method' => 'cash_in',
                            'credited_to' => $cashInRequest->df_id,
                            'authorized_by'=> auth()->user()->df_id,
                        ]
                    )
                );
                $cashInRequest->update($request->all());
            }

            return response()->json([
                'message' => 'Cash In Request Updated Successfully',
                'status' => 'success',
            ], 200);
        }else{
            return response()->json([
                'message' => 'Cash In Request Already Approved',
                'status' => 'success',
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CashInRequest $cashInRequest)
    {
        //
    }


    public function myCashInReq()
    {
        return CashInRequestResource::collection(CashInRequest::where('df_id', auth()->user()->df_id)->get());
    }
}
