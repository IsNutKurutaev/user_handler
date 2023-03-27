<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;

class RegisterRequest extends ApiValidationRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required'],
            'login' => ['required', Rule::unique(User::class, 'login')],
            'password' => ['required']
        ];
    }

}
