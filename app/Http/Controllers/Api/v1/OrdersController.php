<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\InputOrderResource;
use App\Http\Resources\v1\OrderResource;
use App\Models\v1\InputOrder;
use App\Models\v1\order;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(order $order)
    {
        //
    }

    public function orderFromMe($id){
        return InputOrderResource::collection(InputOrder::where('me_id',$id)->get());
    }

    //company wise order
    public function my_order(){
        return OrderResource::collection( Order::where('company_id', auth()->user()->df_id)->get());
    }

    public function orderFromFarmer($id){
        $meOrderId = InputOrder::where('sold_to',$id)->get('order_id');

        $collection = new Collection();
        foreach ($meOrderId as $key => $value) {
            $collection->push(
                OrderResource::make(order::where('me_order_id',$value->order_id)->first())
            );
        }
        return  $collection;
    }
}
