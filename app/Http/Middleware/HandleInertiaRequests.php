<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

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
        return array_merge(parent::share($request), [
            'flash' => fn () => $this->flash($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'locales' => locales(),
        ]);
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
