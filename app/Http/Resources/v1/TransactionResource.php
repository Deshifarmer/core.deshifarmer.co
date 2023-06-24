<?php

namespace App\Http\Resources\v1;

use App\Models\v1\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array

    {
        $ctn = Employee::where('df_id', $this->credited_to)->first()->full_name ?? null;
        $dfn = Employee::where('df_id', $this->debited_from)->first()->full_name ?? null;


        if($this->method == 'order payment'){
            $massage  = "Distributor name: $dfn, confirm payment for order: $this->order_id , amount: $this->amount";
        }elseif($this->method == 'cash in'){
            $massage  = "Distributor name: $ctn, cash in amount: $this->amount, cash in id: $this->cash_in_id";
        }elseif($this->method == 'cash out'){
            $massage  = "Name: $dfn, cash out amount: $this->amount, cash out id: $this->cash_out_id";
        }else(
            $massage = "Name: $ctn, commission: $this->amount, order: $this->order_id"
        );

        return [
            'transaction_id' => $this->transaction_id,
            'amount' => $this->amount,
            'order_id' => $this->order_id,
            'cash_in_id' => $this->cash_in_id,
            'cash_out_id' => $this->cash_out_id,
            'method' => $this->method,
            'credited_to' => $this->credited_to,
            'credited_to_name' => Employee::where('df_id', $this->credited_to)->first()->full_name ?? null,
            'debited_from' => $this->debited_from,
            'debited_from_name' => Employee::where('df_id', $this->debited_from)->first()->full_name ?? null,
            'authorized_by' => $this->authorized_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'massage' => $massage ?? null,


        ];
    }
}
