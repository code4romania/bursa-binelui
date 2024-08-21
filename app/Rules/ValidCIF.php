<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class ValidCIF implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $key = 753217532;

        if (! \is_int($value)) {
            $value = preg_replace('/[^a-z0-9]/i', '', $value);

            if (Str::of($value)->upper()->startsWith('RO')) {
                $value = mb_substr($value, 2);
            }

            $value = \intval($value);
        }

        if ($value < 10 || $value > 999999999) {
            $fail(__('custom_validation.ngo.cif.not_regex', ['attribute' => $attribute]));

            return;
        }

        $c1 = $value % 10;
        $value = (int) ($value / 10);

        $t = 0;
        while ($value > 0) {
            $t += ($value % 10) * ($key % 10);
            $value = (int) ($value / 10);
            $key = (int) ($key / 10);
        }

        $c2 = $t * 10 % 11;

        if ($c2 === 10) {
            $c2 = 0;
        }

        if ($c1 !== $c2) {
            $fail(__('custom_validation.ngo.cif.not_regex', ['attribute' => $attribute]));
        }
    }
}
