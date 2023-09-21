<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\ProductResource;
use App\Models\v1\Order;
use App\Models\v1\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return ProductResource::collection(Product::orderBy('created_at', 'desc')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name'  => 'required|string',
            'category_id' => 'required|integer|exists:product_categories,id',
            'subcategory_id' => 'integer|exists:product_subcategories,id',
        ]);


        $input = $request->all();
        $input["product_id"] = 'pro-' . $this->generateUUID();
        $extension = $request->file('image')->getClientOriginalExtension();
        $request->file('image')->storeAs('public/image/product', $input["product_id"] . '.' . $extension);
        $image_path = '/image/product/' . $input["product_id"] . '.' . $extension;
        $input['image'] =  $image_path;
        $input['company_id'] =  $request->company_id == null ? auth()->user()->df_id : $input['company_id'];
        $input['sell_price'] = $input['sell_price_from_company'];
        Product::create($input);
        return Response()->json([
            'message' => 'Product Created Successfully',
            'status' => 'success',
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return ProductResource|Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }
        $input = $request->all();
        if ($request->hasFile('image')) {
            Storage::delete('public/' . $product->image);
            $extension = $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('public/image/product', $product->product_id . '.' . $extension);
            $image_path = '/image/product/' . $product->product_id . '.' . $extension;
            $input['image'] =  $image_path;
        }
        $product->update(
            $input
        );

        return Response()->json([

            'message' => 'Product Updated Successfully',
            'status' => 'success',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        // $product->delete();
        // return response()->noContent();
    }

    public function sort(Request $request)
    {

        $products = Product::query()

            ->when($request->has('company_id'), function ($query) use ($request) {
                $query->where('company_id', $request->company_id);
            })
            ->when($request->has('category_id'), function ($query) use ($request) {
                $query->where('category_id', $request->category_id);
            })
            ->when($request->has('product_name'), function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->product_name . '%');
            })
            ->where('status', 'active')
            ->inRandomOrder()
            ->paginate($request->input('per_page', 10))
            ->appends(request()->query());

        return ProductResource::collection($products);
    }

    public function companyWiseProduct()
    {
        $products = Product::where('company_id', auth()->user()->df_id)->get();
        return ProductResource::collection($products);
    }

    public function popular_product()
    {
        return Order::where('product_id', '!=', null)
            ->selectRaw('COUNT(*) as total, product_id')
            ->groupBy('product_id')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($order) {
                return ProductResource::make(Product::where('product_id', $order->product_id)->first());
            });
    }
}
