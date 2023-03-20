<?php

namespace App\Http\Requests;

use App\Rules\NotEarlierThenNow;
use App\Rules\NotEarlierThenThat;
use Illuminate\Validation\Rule;

class ShiftRequest extends ApiValidationRequest
{
    public function rules()
    {
        return [
            'start' => ['required', Rule::unique('shifts','start'), new NotEarlierThenNow],
            'end' => ['required', Rule::unique('shifts', 'end'), new NotEarlierThenThat($this->start)],
        ];
    }
}
