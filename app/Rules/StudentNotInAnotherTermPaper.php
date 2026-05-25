<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StudentNotInAnotherTermPaper implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function __construct(
        protected $studentId
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
    }
}
