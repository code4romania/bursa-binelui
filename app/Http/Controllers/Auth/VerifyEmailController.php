<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Events\Organization\SendOrganizationForApproval;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::getDashboardUrl() . '?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));

            if ($request->user()->isOrganizationAdmin()) {
                event(new SendOrganizationForApproval($request->user()->load('organization')->organization));
            }
        }

        return redirect()->intended(RouteServiceProvider::getDashboardUrl() . '?verified=1');
    }
}
