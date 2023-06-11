<?php

namespace App\Http\Resources\v1;

use App\Models\User;
use App\Models\v1\Company;
use App\Models\v1\ProductCategory;
use App\Models\v1\ProductSubcategory;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $companyDet = User::Where('df_id',$this->company_id)->get();
        return [
            'product_id'=>$this->product_id,
            'name'=>$this->name,
            'image'=>$this->image,
            'description'=>$this->description,
            'preferred'=>$this->preferred,
            'category'=>ProductCategory::find($this->category_id)->title,
            'subcategory'=> $this->subcategory_id ? ProductSubcategory::find($this->subcategory_id)->title : null,
            'company'=>$companyDet->implode('first_name') . ' ' . $companyDet->implode('last_name'),
            'sell_price' => $this->sell_price,
            'discount'=>$this->discount,
            'status'=>$this->status,

            'hq_secret'=> $this->when(auth()->user()->role == 0, function () {
                return [
                    'buy_price_from_company'=>$this->buy_price_from_company,
                    'sell_price_from_company'=>$this->sell_price_from_company,
                    'hq_commission'=>$this->hq_commission,
                    'me_commission'=>$this->me_commission,
                    'distributor_commission'=>$this->distributor_commission,
                ];
            }),

        ];
    }
}
