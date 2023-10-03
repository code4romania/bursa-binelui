<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class Recaptcha implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $response = Http::asForm()
            ->post(config('services.google_recaptcha.url'), [
                'secret' => config('services.google_recaptcha.secret_key'),
                'response' => $value,
            ])
            ->json();

        $success = (bool) data_get($response, 'success');
        $score = (float) data_get($response, 'score');

        if (! $success || $score < config('services.google_recaptcha.threshold')) {
            $fail('The :attribute field is invalid.');
        }
    }
}
