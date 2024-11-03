<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Spatie\Newsletter\Facades\Newsletter;

class NewsletterService
{
    public static function subscribe(string $email, ?string $name = null)
    {
        $mergeFields = [
            'MERGE1' => $name,
        ];

        $response = rescue(
            fn () => Newsletter::subscribe($email, $mergeFields),
            false
        );

        if (false !== $response) {
            Log::error('Failed to subscribe user to newsletter', [
                'email' => $email,
                'response' => $response,
            ]);

            // TODO: check if email registered as user
            // and assign subscriber badge if the
            // user doesn't already have one.
        }

        return $response;
    }
}
