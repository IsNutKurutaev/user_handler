<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShiftRequest extends ApiValidationRequest
{
    public function rules()
    {
        return [
            'start' => ['required', Rule::unique('shifts','start')],
            'end' => ['required', Rule::unique('shifts', 'end')],
        ];
    }
}
