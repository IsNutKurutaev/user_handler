<?php

namespace App\Http\Requests;

class CreateOrderRequest extends ApiValidationRequest
{
    public function rules()
    {
        return [
            'work_shift_id' => ['required'],
            'table_id' => ['required'],
        ];
    }
}
