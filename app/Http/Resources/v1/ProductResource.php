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
            'prefered'=>$this->prefered,
            'category'=>ProductCategory::find($this->category_id)->title,
            'subcategory'=> $this->subcategory_id ? ProductSubcategory::find($this->subcategory_id)->title : null,
            'company'=>$companyDet->implode('first_name') . ' ' . $companyDet->implode('last_name'),
            'sell_price' => $this->sell_price,
            'discount'=>$this->discount,

            // 'buy_price_from_company'=>$this->whenAppended('buy_price_from_company', function () {
            //     return $this->buy_price_from_company;
            // }),
            // 'sell_price_from_company'=>$this->whenAppended('sell_price_from_company', function () {
            //     return $this->sell_price_from_company;
            // }),
            // 'hq_commission'=>$this->whenAppended('hq_commission', function () {
            //     return $this->hq_commission;
            // }),
            // 'me_commission'=>$this->whenAppended('me_commission', function () {
            //     return $this->me_commission;
            // }),
            // 'distributor_commission'=>$this->whenAppended('distributor_commission', function () {
            //     return $this->distributor_commission;
            // }),
        ];
    }
}
