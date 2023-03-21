<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;

class NotEarlierThenThat implements Rule
{
    public function __construct($param)
    {
        $this->param = $param;
    }
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $value > $this->param;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The attribute earlier then start';
    }
}
