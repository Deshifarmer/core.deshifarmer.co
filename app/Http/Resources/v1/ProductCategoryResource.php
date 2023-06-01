<?php

namespace App\Http\Resources\v1;

use App\Models\v1\ProductSubcategory;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->image,
            'is_active' => $this->is_active,
            'sub_category'=> ProductSubCategoryResource::collection(ProductSubcategory::where('category_id', $this->id)->get())
        ];
    }
}
