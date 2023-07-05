<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\ProductResource;
use App\Models\v1\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProductResource::collection(Product::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name'  => 'required|string',
            'category_id' => 'required|integer|exists:product_categories,id',
            'subcategory_id' => 'integer|exists:product_subcategories,id',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        $input = $request->all();
        $input["product_id"] = 'pro-' . $this->generateUUID();
        $extension = $request->file('image')->getClientOriginalExtension();
        $request->file('image')->storeAs('public/image/product', $input["product_id"] . '.' . $extension);
        $image_path = '/image/product/' . $input["product_id"] . '.' . $extension;
        $input['image'] =  $image_path;
        $input['company_id'] =  $request->company_id == null ? auth()->user()->df_id : $input['company_id'];
        $input['sell_price'] = $input['sell_price_from_company'];
        $product = Product::create($input);
        return Response()->json([
            'message' => 'Product Created Successfully',
            'status' => 'success',
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product->update(
            $request->all()
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
        if ($request->has('company_id') && $request->has('category_id')) {
            $products = Product::where('company_id', $request->company_id)
                ->where('category_id', $request->category_id)
                ->where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->get();
            return ProductResource::collection($products);
        } elseif ($request->has('product_name') && $request->has('company_id')) {
            $products = Product::where('name', 'LIKE', '%' . $request->product_name . '%')
                ->Where('company_id', $request->company_id)
                ->where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->get();
            return ProductResource::collection($products);
        } elseif ($request->has('company_id')) {
            $products = Product::where('company_id', $request->company_id)
                ->where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->get();
            return ProductResource::collection($products);
        } elseif ($request->has('category_id')) {
            $products = Product::where('category_id', $request->category_id)
                ->where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->get();
            return ProductResource::collection($products);
        } elseif ($request->has('product_name')) {
            $products = Product::where('name', 'LIKE', '%' . $request->product_name . '%')
                ->where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->get();
            return ProductResource::collection($products);
        } else {
            return ProductResource::collection(Product::where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->get());
        }
    }

    public function companyWiseProduct()
    {
        $products = Product::where('company_id', auth()->user()->df_id)->get();
        return ProductResource::collection($products);
    }
}
