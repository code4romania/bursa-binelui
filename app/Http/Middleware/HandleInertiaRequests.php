<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(
            parent::share($request),
            $this->shareOnce($request),
            [
                'appName' => config('app.name'),
                'flash' => fn () => $this->flash($request),
                'auth' => fn () => [
                    'user' => $request->user(),
                    'organization' => [
                        'status' => $request->user()?->organization?->status,
                    ],
                ],
                'locales' => [
                    'available' => locales(),
                    'current' => app()->getLocale(),
                ],
            ]
        );
    }

    /**
     * Define the props that are shared on first load only.
     *
     * @return array<string, mixed>
     */
    public function shareOnce(Request $request): array
    {
        if ($request->inertia()) {
            return [];
        }

        return [
            'ziggy' => new Ziggy(group: null),
        ];
    }

    protected function flash(Request $request): ?array
    {
        $type = match (true) {
            $request->session()->has('error') => 'error',
            $request->session()->has('success') => 'success',
            default => null,
        };

        if ($type === null) {
            return null;
        }

        return [
            'success' => $type === 'success',
            'message' => $request->session()->get($type),
        ];
    }
}
