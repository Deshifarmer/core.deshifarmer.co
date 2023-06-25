<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\InputOrderResource;
use App\Http\Resources\v1\OrderResource;
use App\Models\v1\Employee;
use App\Models\v1\EmployeeAccount;
use App\Models\v1\inputOrder;
use App\Models\v1\Order;
use App\Models\v1\Product;
use App\Models\v1\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\HttpCache\ResponseCacheStrategy;

class InputOrderController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return InputOrderResource::collection(inputOrder::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['me_id'] = auth()->user()->df_id;
        $data['order_id'] = 'Ord-' . $this->generateUUID();
        $data['channel_id'] = Employee::where('df_id', auth()->user()->df_id)->get('channel')->implode('channel');
        $data['distributor_id'] = Employee::where('df_id', auth()->user()->df_id)->get('under')->implode('under');

        $total_price = 0;
        $totalHqCommission = 0;
        $totalMeCommission = 0;
        $totalDistributorCommission = 0;

        for ($i = 0; $i < count($request->{"order"}); $i++) {
            $product_details = Product::where('product_id', $request->{"order"}[$i]["product_id"])->get();
            $product_price = $product_details->implode('sell_price');
            $total_price +=  $product_price * $request->{"order"}[$i]["quantity"];
            $priceIntoQuantity = $product_price * $request->{"order"}[$i]["quantity"];
            $totalHqCommission += round($priceIntoQuantity * floatval($product_details->implode('hq_commission')) / 100, 2);
            $totalMeCommission += round($priceIntoQuantity * floatval($product_details->implode('me_commission')) / 100, 2);
            $totalDistributorCommission += round($priceIntoQuantity * floatval($product_details->implode('distributor_commission')) / 100, 2);
            (new OrdersController)->store(new Request([
                'product_id' => $request->{"order"}[$i]["product_id"],
                'quantity' => $request->{"order"}[$i]["quantity"],
                'unit' => $request->{"order"}[$i]["unit"],
                'me_order_id' => $data['order_id'],
                'me_id' => $data['me_id'],
                'me_commission' =>  round($priceIntoQuantity * floatval($product_details->implode('me_commission')) / 100, 2),
                'distributor_id' => $data['distributor_id'],
                'distributor_commission' => round($priceIntoQuantity * floatval($product_details->implode('distributor_commission')) / 100, 2),
                'channel_id' => $data['channel_id'],
                'company_id' => Product::where('product_id', $request->{"order"}[$i]["product_id"])->get('company_id')->implode('company_id'),
                'total_price' => $priceIntoQuantity,
            ]));
        }
        $data['total_price'] = $total_price;
        $data['hq_commission'] =  $totalHqCommission;
        $data['distributor_commission'] =  $totalDistributorCommission;
        $data['me_commission'] =  $totalMeCommission;
        $orderFromMe = inputOrder::create($data);
        // return new InputOrderResource($orderFromMe);
        return response()->json([
            'message' => 'Successfully and you will get ' . $totalMeCommission . ' tk as commission',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(inputOrder $inputOrder)
    {
        return new InputOrderResource($inputOrder);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, inputOrder $inputOrder)
    {

        if ($request->status == 'confirm by distributor' && $inputOrder->status == 'pending') {

            $orderTotalPrice = $inputOrder->total_price;
            $distributorAccount =  EmployeeAccount::where('acc_number', $inputOrder->distributor_id)->get();

            $newBalance = floatval($distributorAccount->implode('net_balance')) - floatval($orderTotalPrice);

            if ($newBalance < 0) {
                return Response(
                    [
                        'message' => 'Insufficient Balance'
                    ]
                );
            } else {

                (new TransactionController)->store(new Request(
                    [
                        'amount' => $orderTotalPrice,
                        'order_id' => $inputOrder->order_id,
                        'method' => 'order payment',
                        'credited_to' => 'HQ-01',
                        'debited_from' => $inputOrder->distributor_id,
                        'authorized_by' => 'portal',
                    ]
                ));

                (new EmployeeAccountController)->update(new Request(
                    [
                        'net_balance' => $newBalance
                    ]
                ), EmployeeAccount::where('acc_number', $inputOrder->distributor_id)->first());

                $hqAccount =  EmployeeAccount::where('acc_number', 'HQ-01')->first();
                (new EmployeeAccountController)->update(new Request(
                    [
                        'net_balance' => floatval($hqAccount->implode('net_balance')) + $orderTotalPrice
                    ]
                ), $hqAccount);



                $data = $request->all();
                $data['payment_method'] = 'by portal';

                $inputOrder->update($data);

                Order::where('me_order_id', $inputOrder->order_id)->update(['status' => 'confirm by distributor']);

                return Response(
                    [
                        'message' => 'Updated Successfully'
                    ]
                );
            }
        }

        // ** not need now **
        // elseif ($request->status == 'collected by distributor' && $inputOrder->status == 'ready to collect for distributor') {
        //     $productList = Order::where('me_order_id', $inputOrder->order_id)
        //         ->where('status', 'ready to collect for distributor')
        //         ->get('product_id')->implode('product_id', ',');

        //     $productArray = explode(',', $productList);


        //     for ($i = 0; $i < count($productArray); $i++) {
        //         $product = Product::where('product_id', $productArray[$i])->get();

        //         $productCompany = $product->implode('company_id');
        //         $CompanyAccount = EmployeeAccount::where('acc_number', $productCompany)->get('net_balance')->implode('net_balance');
        //         $companyBuyPrice = floatval($product->implode('buy_price_from_company'))  * floatval(Order::where('me_order_id', $inputOrder->order_id)->where('product_id', $productArray[$i])->get('quantity')->implode('quantity'));

        //         $companyNewBalance = floatval($CompanyAccount) + $companyBuyPrice;

        //         EmployeeAccount::where('acc_number', $productCompany)->update(
        //             [
        //                 'net_balance' =>  $companyNewBalance
        //             ]
        //         );

        //         EmployeeAccount::where('acc_number', 'HQ-01')->update(
        //             [
        //                 'net_balance' =>  floatval(EmployeeAccount::where('acc_number', 'HQ-01')->implode('net_balance')) - $companyBuyPrice
        //             ]
        //         );
        //         (new TransactionController)->store(
        //             new Request(
        //                 [
        //                     'amount' => $companyBuyPrice,
        //                     'order_id' => $inputOrder->order_id,
        //                     'method' => 'paid to company',
        //                     'credited_to' => $productCompany,
        //                     'debited_from' => 'HQ-01',
        //                     'authorized_by' => 'portal',
        //                 ]
        //             )
        //         );
        //     }

        //     $inputOrder->update($request->all());
        //     return Response(
        //         [
        //             'message' => 'Updated Successfully'
        //         ]
        //     );
        // }
        elseif ($request->status == 'collected by me' && $inputOrder->status == 'ready to collect for me') {

            $distributorAccount =  EmployeeAccount::where('acc_number', $inputOrder->distributor_id)->get();

            $newBalance = floatval($distributorAccount->implode('net_balance')) + floatval($inputOrder->distributor_commission);

            (new EmployeeAccountController)->update(new Request(
                [
                    'net_balance' => $newBalance
                ]
            ), EmployeeAccount::where('acc_number', $inputOrder->distributor_id)->first());

            (new TransactionController)->store(
                new Request(
                    [
                        'amount' => $inputOrder->distributor_commission,
                        'order_id' => $inputOrder->order_id,
                        'method' => 'commission',
                        'credited_to' => $inputOrder->distributor_id,
                        'debited_from' => 'HQ-01',
                        'authorized_by' => 'portal',
                    ]
                )
            );

            $meAccount =  EmployeeAccount::where('acc_number', $inputOrder->me_id)->get();

            $meNewBalance = floatval($meAccount->implode('net_balance')) + floatval($inputOrder->me_commission);
            (new EmployeeAccountController)->update(new Request(
                [
                    'net_balance' => $meNewBalance
                ]
            ), EmployeeAccount::where('acc_number', $inputOrder->me_id)->first());

            (new TransactionController)->store(
                new Request(
                    [
                        'amount' => $inputOrder->me_commission,
                        'order_id' => $inputOrder->order_id,
                        'method' => 'commission',
                        'credited_to' => $inputOrder->me_id,
                        'debited_from' => 'HQ-01',
                        'authorized_by' => 'portal',
                    ]
                )
            );

            $hqAccount =  EmployeeAccount::where('acc_number', 'HQ-01')->first();
            (new EmployeeAccountController)->update(new Request(
                [
                    'net_balance' =>  floatval($hqAccount->implode('net_balance')) - (floatval($inputOrder->distributor_commission) + floatval($inputOrder->me_commission))
                ]
            ), EmployeeAccount::where('acc_number', 'HQ-01')->first());

            Order::where('me_order_id', $inputOrder->order_id)
                ->whereNotIn('status', ['rejected by company'])
                ->update(['status' => 'collected by me']);

            $inputOrder->update($request->all());

            return Response(
                [
                    'message' => 'Updated Successfully'
                ]
            );
        } else {
            return Response(
                [
                    'message' => 'still processing'
                ]
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(inputOrder $inputOrder)
    {
        //
    }


    public function meNewOrder()
    {
        return InputOrderResource::collection(
            inputOrder::where('distributor_id', auth()->user()->df_id)
                ->where('status', 'pending')
                ->get()
        );
    }

    public function meConfirmOrderStatus()
    {

        return InputOrderResource::collection(
            inputOrder::where('distributor_id', auth()->user()->df_id)
                ->where('status', 'confirm by distributor')
                ->orWhere('status', 'processing by company')
                ->get()
        );
    }

    public function input_order_details($id)
    {
        return OrderResource::collection(
            Order::where('me_order_id', $id)->get()
        );
    }

    public function meCollection()
    {
        return InputOrderResource::collection(
            inputOrder::where('distributor_id', auth()->user()->df_id)
                ->where('status', 'ready to collect for me')
                ->get()
        );
    }

    public function collectOrder()
    {
        return InputOrderResource::collection(
            inputOrder::where('me_id', auth()->user()->df_id)
                ->where('status', 'ready to collect for me')
                ->get()
        );
    }


    public function myOrder()
    {
        return
            InputOrderResource::collection(
                inputOrder::where('me_id', auth()->user()->df_id)
                    ->get()
            );
    }
}
