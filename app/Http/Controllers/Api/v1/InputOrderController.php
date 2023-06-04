<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\InputOrderResource;
use App\Models\v1\Employee;
use App\Models\v1\inputOrder;
use App\Models\v1\Product;
use Illuminate\Http\Request;

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
        $data['order_id'] ='Ord-' . $this->generateUUID();
        $data['channel_id'] = Employee::where('df_id', auth()->user()->df_id)->get('channel')->implode('channel');
        $data['distributor_id']= Employee::where('df_id', auth()->user()->df_id)->get('under')->implode('under');

        $total_price = 0;
        for($i = 0; $i < count($request->{"order"}); $i++){
            $product_price = Product::where('product_id', $request->{"order"}[$i]["product_id"])->get('sell_price')->implode('sell_price');
            $total_price +=  $product_price * $request->{"order"}[$i]["quantity"];

            (new OrdersController)->store( new Request([
                'product_id' => $request->{"order"}[$i]["product_id"],
                'quantity' => $request->{"order"}[$i]["quantity"],
                'unit' => $request->{"order"}[$i]["unit"],
                'me_order_id' => $data['order_id'],
                'channel_id' => $data['channel_id'],
                'company_id' => Product::where('product_id', $request->{"order"}[$i]["product_id"])->get('company_id')->implode('company_id'),
                'total_price' =>  $product_price * $request->{"order"}[$i]["quantity"],
            ]));
        }
        $data['total_price'] = $total_price;


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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(inputOrder $inputOrder)
    {
        //
    }


    public function meOrder(){
        return InputOrderResource::collection(
            inputOrder::where('distributor_id',auth()->user()->df_id)->get()
        );
    }
}
