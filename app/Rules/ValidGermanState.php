<?php

namespace App\Rules;

use App\Enums\GermanState;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidGermanState implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value)) {
            $fail('The :attribute must be a string.');
            return;
        }

        if (GermanState::fromValue($value) === null) {
            $fail('The :attribute must be a valid German state.');
        }
    }
}
