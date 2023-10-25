<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\SourceSellingListResource;
use App\Http\Resources\v1\SourceSellingResource;
use App\Models\v1\OutputCustomer;
use App\Models\v1\SourceSelling;
use App\Models\v1\Sourcing;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SourceSellingController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return SourceSellingListResource::collection(
            SourceSelling::whereDate('created_at',Request()->date)->latest()->paginate(Request()->input('per_page', 50))
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
        $input['unit']= $source->unit;
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

    public function dayWiseSourceSelling()
    {


        $startDate = Request()->start_date ?? Carbon::now()->subDays(15)->toDateString();
        $endDate =Request()->end_date ?? Carbon::now()->toDateString();
        $daysDifference = Carbon::createFromDate($startDate)->diffInDays(Carbon::createFromDate($endDate));

        $sourceSellingData = collect();
        for($i=0;$i<=$daysDifference;$i++){
            $date = Carbon::createFromDate($endDate)->subDays($i)->toDateString();
            $sourceSellingData ->push( [
                'date' => $date,
                'total_selling' => SourceSelling::whereDate('created_at',$date)->sum('sell_price'),
                'unit_wise_selling' => SourceSelling::whereDate('created_at',$date)->select('unit',DB::raw('sum(quantity) as total_quantity'),DB::raw('sum(sell_price) as total_sell_price'))->groupBy('unit')->get(),

            ]);
        }

        return response()->json(
            $sourceSellingData
        , 200);


    }
}
