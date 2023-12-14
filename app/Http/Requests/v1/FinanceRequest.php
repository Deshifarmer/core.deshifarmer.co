<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class FinanceRequest extends FormRequest
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
            'which_farmer' =>'required|exists:farmers,farmer_id',
            'season'=>'required|string',
            'producing_crop'=>'required|string',
            'variety'=>'string',
            'purpose_of_loan'=>'required|string',
            'amount_of_loan'=>'required',
            'season_and_eta_sales'=>'string',
            'note'=>'string',
            'payment_schedule'=>'required|string',
            'payment_dates'=>'required',
        ];
    }
}
