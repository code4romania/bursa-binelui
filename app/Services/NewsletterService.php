<?php

declare(strict_types=1);

namespace App\Services;

use Spatie\Newsletter\Facades\Newsletter;

class NewsletterService
{
    public static function subscribe(string $email, ?string $name = null)
    {
        $mergeFields = [
            'MERGE1' => $name,
        ];

        $options = [
            'pending' => true,
        ];

        $response = rescue(
            fn () => Newsletter::subscribe($email, $mergeFields, options: $options),
            false
        );

        if (false !== $response) {
            // TODO: check if email registered as user
            // and assign subscriber badge if the
            // user doesn't already have one.
        }

        return $response;
    }
}
