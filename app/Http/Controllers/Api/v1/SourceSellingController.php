<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\SourceSellingListResource;
use App\Http\Resources\v1\SourceSellingResource;
use App\Models\v1\OutputCustomer;
use App\Models\v1\SourceSelling;
use App\Models\v1\Sourcing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SourceSellingController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return SourceSellingListResource::collection(
            SourceSelling::latest()->paginate(Request()->input('per_page', 10))
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'source_id' => 'required|exists:sourcings,source_id',
            'sell_location' => 'required',
            'sell_price' => 'required',
            'quantity' => 'required',
            'market_type' => 'required',
            'customer_id' => 'exists:output_customers,customer_id',
            'phone_number' => 'required_without:customer_id|unique:output_customers,phone_number',
            'email' => 'unique:output_customers,email',
            'name' => 'required_without:customer_id',


        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $source = Sourcing::where('source_id', $request->source_id)->first();
        if ($source->quantity < $request->quantity) {
            return response()->json(
                ['error' => 'Quantity is not available'],
                401
            );
        }
        $source->quantity = $source->quantity - $request->quantity;
        $source->sell_price = $request->sell_price;
        $source->save();

        $input = $request->all();
        if ($request->has('customer_id')) {
            $input['customer_id'] = $request->customer_id;
        } else {
            $input['customer_id'] = 'Cust-' . $this->generateUUID();
            OutputCustomer::create([
                'customer_id' => $input['customer_id'],
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'onboard_by' => auth()->user()->df_id
            ]);
        }

        $input['sold_by'] = auth()->user()->df_id;
        SourceSelling::create($input);
        return response()->json([
            'success' => 'Source Selling Created Successfully'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(SourceSelling $sourceSelling)
    {
        return new SourceSellingResource($sourceSelling);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SourceSelling $sourceSelling)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SourceSelling $sourceSelling)
    {
        //
    }
}
