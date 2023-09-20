<?php

declare(strict_types=1);

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UserDoesntBelongToAnOrganization implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exists = User::query()
            ->where($attribute, $value)
            ->whereNotNull('organization_id')
            ->exists();

        if ($exists) {
            $fail(__('validation.user_belongs_to_organization'));
        }
    }
}
