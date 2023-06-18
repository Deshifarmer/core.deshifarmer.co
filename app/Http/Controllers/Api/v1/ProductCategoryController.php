<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Resources\v1\ProductCategoryResource;

use App\Models\v1\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProductCategoryResource::collection(
            ProductCategory::all()
        );
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
            'title' => 'required|string|unique:product_categories',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }
        $data = $request->all();
        $extension = $request->file('image')->getClientOriginalExtension();
        $request->file('image')->storeAs('public/image/category', $data['title'] . '.' . $extension);
        $image_path ='/image/category/'. $data['title'] . '.' . $extension;
        $data['image'] =  $image_path;

        $productCategory = ProductCategory::create($data);
        return new ProductCategoryResource($productCategory);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCategory $productCategory)
    {
        return new ProductCategoryResource($productCategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        $productCategory->update($request->all());
        return new ProductCategoryResource($productCategory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCategory $productCategory)
    {
        // $productCategory->delete();
        // return response()->noContent();
    }
}
