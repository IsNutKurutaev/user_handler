<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends ApiValidationRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
        {
        return [
            'login' => ['required'],
            'password' => ['required'],
        ];
    }
}
