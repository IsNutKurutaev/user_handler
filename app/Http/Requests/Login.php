<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Login extends ApiValidation
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
