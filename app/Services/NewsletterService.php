<?php

declare(strict_types=1);

namespace App\Services;

use Spatie\Newsletter\Facades\Newsletter;

class NewsletterService
{
    public static function subscribe(string $email, ?string $name = null)
    {
        $mergeFields = [
            // TODO: add field for full name
            'NAME' => $name,
        ];

        $options = [
            'pending' => true,
        ];

        $response = Newsletter::subscribe($email, $mergeFields, options: $options);

        if (false !== $response) {
            // TODO: check if email registered as user
            // and assign subscriber badge if the
            // user doesn't already have one.
        }
    }
}
