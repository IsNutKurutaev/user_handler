<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeOrderStatusRequest extends ApiValidationRequest
{
    public function rules()
    {
        return [
            'status' => ['required',],
        ];
    }
}
