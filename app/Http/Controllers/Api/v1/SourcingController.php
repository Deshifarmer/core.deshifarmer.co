<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\SourcingResource;
use App\Models\v1\SourceSelling;
use App\Models\v1\Sourcing;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SourcingController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return SourcingResource::collection(Sourcing::latest()->paginate(Request()->input('per_page', 10)));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'which_farmer' => 'required|exists:farmers,farmer_id',
            'batch_id' => 'exists:batches,batch_id',
            'product_name' => 'required|string',
            'buy_price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'unit' => 'required|string',
            'source_location' => 'required|string',

        ]);
        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors(),
            ], 422);
        }
        $data = $request->only([
            'which_farmer',
            'batch_id',
            'product_name',
            'product_images',
            'buy_price',
            'quantity',
            'variety',
            'unit',
            'description',
            'source_location',
            'is_sorted',
            'is_active',
        ]);
        $paths = [];
        $data['source_id'] = 'Source-' . $this->generateUUID();
        if($request->hasFile('product_images')){
            $product_image = $request->product_images;
            foreach ($product_image as $key => $image) {
                $extension = $image->getClientOriginalExtension();
                $image->storeAs('public/image/sourcing/', $key . $data['source_id'] . '.' . $extension);
                $imagePath = '/image/sourcing/' . $key . $data['source_id'] . '.' . $extension;
                $paths[] = $imagePath;
            }
        }
        $data['source_by'] = auth()->user()->df_id;
        $data['product_images'] = $paths;

        //this function is only for recent market linkage
        if(Auth::user()->df_id!='HQ-01'){
            SourceSelling::create(
                [
                    'source_id' => $data['source_id'],
                    'sell_location' => $request->market_name,
                    'sell_price' => $data['buy_price'],
                    'quantity' => $data['quantity'],
                    'market_type' => 'Market Linkage',
                    'customer_id' => 'Cust-0690-7c252',
                    'sold_by' => auth()->user()->df_id,
                    'unit' => $data['unit'],
                ]
            );
            $data['sell_price'] = $data['buy_price'];
            $data['quantity'] = 0;

        }
        //this function is only for recent market linkage
        Sourcing::create($data);
        return response()->json([
            'message' => 'Sourcing created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sourcing $sourcing)
    {
        return SourcingResource::make($sourcing);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sourcing $sourcing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sourcing $sourcing)
    {
        //
    }
    public function mySourcing(){
        $startDate = Request()->start_date ?? Carbon::now()->subDays(20)->toDateString();
        $endDate =Request()->end_date ?? Carbon::now()->toDateString();
        return SourcingResource::
        collection(
            Sourcing::where('source_by',auth()->user()->df_id)
            ->whereBetween('created_at', [$startDate, $endDate])->latest()->get());
    }
}

