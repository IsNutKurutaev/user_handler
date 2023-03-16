<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddUserOnShiftRequest extends ApiValidationRequest
{
    public function rules()
    {
        return [
            'user_id' => ['required'],
        ];
    }
}
