<?php

namespace App\Rules;

use App\Models\Dependent;
use App\Models\Member;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class RegistrationExists implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $existsInMember = Member::where('registration_number', $value)->exists();
        $existsInDependents = Dependent::where('registration_number', $value)->exists();

        if (!$existsInMember && !$existsInDependents) {
            $fail('Essa matrícula é inválida ou não possui cadastro.');
        }
    }
}
