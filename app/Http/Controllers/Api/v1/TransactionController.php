<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\TransactionResource;
use App\Models\v1\InputOrder;
use App\Models\v1\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TransactionResource::collection(Transaction::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['transaction_id'] = 'Tr-' . $this->generateUUID().'-'.Carbon::now()->format('Ymd');
        if($request->has('order_id')){
          InputOrder::where('order_id', $request->order_id)->update(['payment_id' => $data['transaction_id']]);
        }
        Transaction::create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }

    public function myTransactions()
    {
        return TransactionResource::collection(
            Transaction::where('credited_to', auth()->user()->df_id)
            ->orWhere('debited_from', auth()->user()->df_id)
            ->get()
        );
    }
}
