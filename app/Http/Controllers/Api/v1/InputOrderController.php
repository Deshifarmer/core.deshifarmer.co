<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\InputOrderResource;
use App\Http\Resources\v1\OrderResource;
use App\Models\v1\Employee;
use App\Models\v1\inputOrder;
use App\Models\v1\Order;
use App\Models\v1\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
        for ($i = 0; $i < count($request->{"order"}); $i++) {
            $product_details = Product::where('product_id', $request->{"order"}[$i]["product_id"])->get();
            $product_price = $product_details->implode('sell_price');
            $total_price +=  $product_price * $request->{"order"}[$i]["quantity"];
            $priceIntoQuantity = $product_price * $request->{"order"}[$i]["quantity"];
            $totalHqCommission = round($priceIntoQuantity * floatval($product_details->implode('hq_commission'))/100, 2);
            $totalMeCommission = round($priceIntoQuantity * floatval($product_details->implode('me_commission'))/100, 2);
            $totalDistributorCommission = round($priceIntoQuantity * floatval($product_details->implode('distributor_commission'))/100, 2);
            (new OrdersController)->store(new Request([
                'product_id' => $request->{"order"}[$i]["product_id"],
                'quantity' => $request->{"order"}[$i]["quantity"],
                'unit' => $request->{"order"}[$i]["unit"],
                'me_order_id' => $data['order_id'],
                'me_id' => $data['me_id'],
                'distributor_id' => $data['distributor_id'],
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
        return new InputOrderResource($orderFromMe);
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
        $inputOrder->update($request->all());

        Order::where('me_order_id', $inputOrder->order_id)->update([
            'status' => $request->status
        ]);
        return Response(
            [
                'message' => 'Updated Successfully'
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(inputOrder $inputOrder)
    {
        //
    }


    public function meOrder()
    {
        return InputOrderResource::collection(
            inputOrder::where('distributor_id', auth()->user()->df_id)->get()
        );
    }

    public function input_order_details($id)
    {
        return OrderResource::collection(
            Order::where('me_order_id', $id)->get()
        );
    }
}
