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
            'flash' => [
                'success_message' => fn () => $request->session()->get('success_message'),
                'error_message' => fn () => $request->session()->get('error_message'),
                'data' => fn () => $request->session()->get('data'),
            ],
            'auth' => [
                'user' => $request->user(),
            ],
            'locales' => locales(),
            'google_maps_api_key' => config('services.google_maps_api_key'),
        ]);
    }
}
