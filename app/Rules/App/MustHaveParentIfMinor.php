<?php

namespace App\Rules\App;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MustHaveParentIfMinor implements ValidationRule
{
    protected mixed $fatherId;
    protected mixed $motherId;

    public function __construct($fatherId = null, $motherId = null)
    {
        $this->fatherId = $fatherId;
        $this->motherId = $motherId;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$value) {
            return;
        }

        // ✅ $value is birth_date (string Y-m-d)
        $birthDate = Carbon::parse($value);

        $age = $birthDate->age;

        if ($age >= 18) {
            return;
        }

        if (!$this->fatherId || !$this->motherId) {
            $fail(__('rules.patient.minor_requires_parent'));
        }
    }
}
