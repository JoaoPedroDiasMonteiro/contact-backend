<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneNumber implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $pattern = '/^[^a-zA-Z]+$/';

        $passes = preg_match($pattern, $value);

        if (! $passes) {
            $fail(__('validation.exists'));
        }
    }
}
