<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NotEarlierThenThat implements ValidationRule
{
    public function __construct($params)
    {
        $this->params = $params;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value < $this->params) {
            $fail('The attribute earlier then start');
        }
    }
}
