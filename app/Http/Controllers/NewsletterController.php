<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\NewsletterService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class NewsletterController extends Controller
{
    public function __invoke(Request $request)
    {
        $attributes = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $response = NewsletterService::subscribe($attributes['email']);

        if (false === $response) {
            throw ValidationException::withMessages([
                'email' => __('user.action.errorSubscribingToNewsletter'),
            ]);
        }
    }
}
