<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Spatie\Newsletter\Facades\Newsletter;

class NewsletterService
{
    public static function subscribe(string $email, ?string $name = null)
    {
        $mergeFields = [];
        if (filled($name)) {
            $mergeFields = [
                'MERGE1' => $name,
            ];
        }
        $response = rescue(
            fn () => Newsletter::subscribe($email, $mergeFields),
            false
        );

        if (false !== $response) {
            Log::error('Failed to subscribe user to newsletter', [
                'email' => $email,
                'response' => $response,
                'error' => Newsletter::getApi()->getLastError(),
            ]);

            // TODO: check if email registered as user
        }

        return $response;
    }
}
