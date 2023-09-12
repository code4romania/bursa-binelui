<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Inertia\Inertia;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        $response = parent::render($request, $e);

        if (! app()->isLocal() && \in_array($response->status(), [401, 403, 404, 429, 500, 503])) {
            return Inertia::render('Error', [
                'status' => $response->status(),
                'title' => __('error.' . $response->status() . '.title'),
                'message' => __('error.' . $response->status() . '.message'),
            ])
                ->toResponse($request)
                ->setStatusCode($response->status());
        }

        if ($response->status() === 419) {
            return back()->with([
                'message' => __('error.419.message'),
            ]);
        }

        return $response;
    }
}
