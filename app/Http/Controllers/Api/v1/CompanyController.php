<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\CompanyResource;
use App\Http\Resources\v1\OrderResource;
use App\Models\v1\Company;
use App\Models\v1\Order;
use App\Models\v1\Product;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CompanyResource::collection(Company::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $company = Company::create($request->all());
        return new CompanyResource($company);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return new CompanyResource($company);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        //
    }


    public function companyOrders(Company $company)
    {
        return OrderResource::collection(
            Order::where('product_id', Product::where('company_id', $company->id)->get()->implode('product_id'))
        ->where('status','pending')
        ->get());


    }
}
