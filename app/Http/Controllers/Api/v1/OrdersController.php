<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\InputOrderResource;
use App\Http\Resources\v1\OrderResource;
use App\Models\v1\EmployeeAccount;
use App\Models\v1\InputOrder;
use App\Models\v1\Order;
use App\Models\v1\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;


class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return OrderResource::collection(order::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $order = Order::create($request->all());
        return new OrderResource($order);
    }

    /**
     * Display the specified resource.
     */
    public function show(order $order)
    {
        return new OrderResource($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, order $order)
    {

        $order->update($request->all());

        $totalProduct = Order::where('me_order_id', $order->me_order_id)->get();
        if ($request->status == 'processing by company' || $request->status == 'rejected by company') {
            if ($request->status == 'rejected by company') {

                $inputOrder = InputOrder::where('order_id', $order->me_order_id)->first();

                $newTotal_price = $inputOrder->total_price - $order->total_price;
                $pro =  Product::where('product_id', $order->product_id)->first();
                $newMeCommission = floatval($inputOrder->me_commission) -  floatval($order->me_commission);
                $newDbCommission =  floatval($inputOrder->distributor_commission) - floatval($order->distributor_commission);

                $inputOrder->update([
                    'total_price' => $newTotal_price,
                    'me_commission' => $newMeCommission,
                    'distributor_commission' => $newDbCommission,
                ]);

                (new TransactionController)->store(
                    new Request([
                        'method' => 'refund',
                        'amount' => $order->total_price,
                        'credited_to' => $order->distributor_id,
                        'debited_from' => 'HQ-01',
                    ])

                );

                EmployeeAccount::where('acc_number', $order->distributor_id)
                    ->update([
                        'net_balance' => EmployeeAccount::where('acc_number', $order->distributor_id)->first()->net_balance + $order->total_price
                    ]);
                EmployeeAccount::where('acc_number', 'HQ-01')
                    ->update([
                        'net_balance' => EmployeeAccount::where('acc_number', 'HQ-01')->first()->net_balance - $order->total_price
                    ]);
                $order->update([
                    'me_commission' => 0.0,
                    'distributor_commission' => 0.0
                ]);
            }
            $companyProductStatus = Order::where('me_order_id', $order->me_order_id)
                ->where('status', 'rejected by company')
                ->orWhere('status', 'processing by company')
                ->get();
            if ($companyProductStatus->count() == $totalProduct->count()) {
                InputOrder::where('order_id', $order->me_order_id)
                    ->update(['status' => 'processing by company']);
            }
            $companyrejectStatus = Order::where('me_order_id', $order->me_order_id)
                ->where('status', 'rejected by company')
                ->get();
            if ($companyrejectStatus->count() == $totalProduct->count()) {
                InputOrder::where('order_id', $order->me_order_id)
                    ->update(['status' => 'rejected by company']);
            }
        }
        if ($request->status == 'deliver from company') {
            $companyProductStatus = Order::where('me_order_id', $order->me_order_id)
                ->where('status', 'deliver from company')
                ->orWhere('status', 'rejected by company')
                ->get();
            if ($companyProductStatus->count() == $totalProduct->count()) {
                InputOrder::where('order_id', $order->me_order_id)
                    ->update(['status' => 'ready to collect for distributor']);
            }
            return  InputOrder::where('order_id', $order->me_order_id)->get();
        }

        if ($request->status == 'collected by distributor') {
            $companyProductStatus = Order::where('me_order_id', $order->me_order_id)
                ->where('status', 'collected by distributor')
                ->orWhere('status', 'rejected by company')
                ->get();

            $companyNetBalance = EmployeeAccount::where('acc_number', $order->company_id)->get()->implode('net_balance');
            $companyBuyPrice = Product::where('product_id', $order->product_id)->get()->implode('buy_price_from_company');

            EmployeeAccount::where('acc_number', $order->company_id)->update(
                [
                    'net_balance' => floatval($companyNetBalance) + (floatval($companyBuyPrice) * $order->quantity)
                ]
            );
            EmployeeAccount::where('acc_number', 'HQ-01')->update(
                [
                    'net_balance' =>  floatval(EmployeeAccount::where('acc_number', 'HQ-01')->implode('net_balance')) -  (floatval($companyBuyPrice) * $order->quantity)
                ]
            );

            (new TransactionController)->store(
                new Request(
                    [
                        'amount' => floatval($companyBuyPrice) * $order->quantity,
                        'order_id' => $order->me_order_id,
                        'method' => 'paid to company',
                        'credited_to' => $order->company_id,
                        'debited_from' => 'HQ-01',
                        'authorized_by' => 'portal',
                    ]
                )
            );


            if ($companyProductStatus->count() == $totalProduct->count()) {
                $order->id;
                InputOrder::where('order_id', $order->me_order_id)
                    ->update(['status' => 'ready to collect for me']);
            }
        }
        return Response([
            'message' => 'status updated'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(order $order)
    {
        //
    }

    public function orderFromMe($id)
    {
        return InputOrderResource::collection(InputOrder::where('me_id', $id)->get()->sortByDesc('created_at'));
    }

    //company wise order
    public function company_new_order()
    {
        return OrderResource::collection(
            Order::where('company_id', auth()->user()->df_id)
                ->where('status', 'confirm by df cp')
                ->get()
        );
    }
    public function company_confirm_order()
    {
        return OrderResource::collection(
            Order::where('company_id', auth()->user()->df_id)
                ->where('status', 'processing by company')
                ->get()
        );
    }
    public function company_delivery_history()
    {
        return OrderResource::collection(
            Order::where('company_id', auth()->user()->df_id)
                ->whereNotIn('status', ['pending', 'confirm by df cp', 'processing by company'])
                ->get()
        );
    }

    public function disCollectOrder()
    {
        return OrderResource::collection(
            Order::where('distributor_id', auth()->user()->df_id)
                ->where('status', 'deliver from company')
                ->get()
        );
    }

    public function orderFromFarmer($id)
    {
        $meOrderId = InputOrder::where('sold_to', $id)->get('order_id');

        $collection = new Collection();
        foreach ($meOrderId as $key => $value) {
            $collection->push(
                OrderResource::make(order::where('me_order_id', $value->order_id)->first())
            );
        }
        return  $collection;
    }

    public function distributorOrder($dis_id)
    {
        return   OrderResource::collection(Order::where('distributor_id', $dis_id)->get());
    }

    public function meOrder($me_id)
    {
        return OrderResource::collection(Order::where('me_id', $me_id)->get());
    }
}
