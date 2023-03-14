<?php

namespace App\Http\Requests;

class Register extends ApiValidation
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'login' => ['required', 'unique:users,login'],
            'password' => ['required']
        ];
    }

}
