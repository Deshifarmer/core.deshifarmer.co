<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\v1\CashOutRequest;
use App\Models\v1\EmployeeAccount;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class CashOutRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CashOutRequest::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['requested_by'] = auth()->user()->df_id;

        $netBalance = EmployeeAccount::where('acc_number', $data['requested_by'])->get('net_balance')->implode('net_balance');
        if ($netBalance < $data['amount']) {
            return Response([
                'message' => 'Insufficient Balance',
            ], 400);
        } else {
            CashOutRequest::create($data);
            return Response([
                'message' => 'Cash out request sent successfully'
            ], 201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CashOutRequest $cashOutRequest)
    {
        return $cashOutRequest;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CashOutRequest $cashOutRequest)
    {
        $employeeAcc = EmployeeAccount::where('acc_number', $cashOutRequest->requested_by)->first();

        if ($cashOutRequest->status == 'pending' && floatval($employeeAcc->net_balance)>floatval($request->accepted)) {
            if ($request->status == 'accepted') {
                $employeeAcc->update([
                    'net_balance' => floatval($employeeAcc->net_balance) - floatval($request->accepted)
                ]);
                (new TransactionController)->store(
                    new Request(
                        [
                            'amount' => $request->accepted,
                            'method' => 'cash out',
                            'description' => 'Cash out request accepted',
                            'debited_from' => $cashOutRequest->requested_by,
                        ]
                    )
                );
                $cashOutRequest->update($request->all());
                return Response([
                    'message' => 'Cash out request accepted successfully'
                ], 200);
            } else if ($request->status == 'rejected') {
                $cashOutRequest->update($request->all());
                return Response([
                    'message' => 'Cash out request rejected successfully'
                ], 200);
            } else {
                return Response([
                    'message' => 'Invalid status'
                ], 400);
            }
        } else {
            return Response([
                'message' => 'insufficient balance or invalid status'
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CashOutRequest $cashOutRequest)
    {
        //
    }

    public function myCashOutRequests()
    {
        return CashOutRequest::where('requested_by', auth()->user()->df_id)->get();
    }
}
