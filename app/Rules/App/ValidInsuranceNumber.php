<?php

namespace App\Rules\App;

use App\Models\Patient;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidInsuranceNumber implements ValidationRule
{
    protected mixed $fatherId;
    protected mixed $motherId;
    protected mixed $birthDate;

    public function __construct($fatherId = null, $motherId = null, $birthDate = null)
    {
        $this->fatherId = $fatherId;
        $this->motherId = $motherId;
        $this->birthDate = $birthDate;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$value || !$this->birthDate) {
            return;
        }

        $age = Carbon::parse($this->birthDate)->age;

        $isMinor = $age < 18;
        $hasParent = $this->fatherId || $this->motherId;

        if ($isMinor && $hasParent) {

            $exists = Patient::where('insurance_number', $value)->exists();

            if ($exists) {
                $fail(__('rules.insurance.unique_minor_with_parent'));
            }
        }
    }
}
