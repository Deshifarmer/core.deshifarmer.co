<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\InputOrderResource;
use App\Http\Resources\v1\OrderResource;
use App\Models\v1\InputOrder;
use App\Models\v1\order;
use App\Models\v1\Product;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Input\Input;

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
            $companyProductStatus = Order::where('me_order_id', $order->me_order_id)
                ->where('status', 'rejected by company')
                ->orWhere('status', 'processing by company')
                ->get();
            if ($companyProductStatus->count() == $totalProduct->count()) {
                InputOrder::where('order_id', $order->me_order_id)
                    ->update(['status' => 'processing by company']);
            }
        }
        if($request->status == 'deliver from company'){
            $companyProductStatus = Order::where('me_order_id', $order->me_order_id)
                ->where('status', 'deliver from company')
                ->orWhere('status', 'rejected by company')
                ->get();
            if ($companyProductStatus->count() == $totalProduct->count()) {
                InputOrder::where('order_id', $order->me_order_id)
                    ->update(['status' => 'ready to collect for distributor']);
            }
        }
        if($request->status == 'collected by distributor'){
            $companyProductStatus = Order::where('me_order_id', $order->me_order_id)
                ->where('status', 'collected by distributor')
                ->orWhere('status', 'rejected by company')
                ->get();
            if ($companyProductStatus->count() == $totalProduct->count()) {
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
        return InputOrderResource::collection(InputOrder::where('me_id', $id)->get());
    }

    //company wise order
    public function company_new_order()
    {
        return OrderResource::collection(
            Order::where('company_id', auth()->user()->df_id)
                ->where('status', 'confirm by distributor')
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
                ->where('status', 'deliver from company')
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
