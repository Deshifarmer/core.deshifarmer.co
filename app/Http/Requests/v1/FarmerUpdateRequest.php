<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class FarmerUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'first_name' => 'string',
            'last_name' => 'string',
            'nid' => 'integer|unique:farmers,nid,' ,
            'gov_farmer_id' => 'integer',
            'fathers_name' => 'string',
            'is_married' => 'boolean',
            'date_of_birth' => 'date',
            'address'=> 'string',
            'village' => 'string',
            'union' => 'string',
            'upazila' => 'integer',
            'district' => 'integer',
            'division' => 'integer',
            'resident_type' => 'string',
            'family_member' => 'integer',
            'number_of_children' => 'integer',
            'yearly_income' => 'integer',
            'year_of_stay_in' => 'integer',
            'group_id' => 'string',
            // 'farm_area' => 'string',
            // 'farm_type' => 'string',
            // 'bank_details' => 'array',
            // 'mfs_account' => 'array',
            // 'current_producing_crop' => 'array',
            // 'focused_crop' => 'array',
            // 'farm_id' => 'array',
            // 'cropping_intensity' => 'string',
            // 'cultivation_practice' => 'string',
            'is_active' => 'boolean',

        ];
    }
}
