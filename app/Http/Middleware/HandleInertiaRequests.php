<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;
use Throwable;
use Inertia\Inertia;

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
        $impersonate = app('impersonate');
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
                'pendidik' => $request->user()?->pendidik,
                'provinsi' => $request->user()?->provinsi,
                'kabupaten' => $request->user()?->kabupaten,
            ],
            'impersonate' => [
                'isImpersonate' => $impersonate->isImpersonating()
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'user.permissions' => function () use ($request) {
                return $request->user() ? $request->user()->getAllPermissions()->pluck('name') : null;
            },
            'user.roles' => function () use ($request) {
                return $request->user() ? $request->user()->roles()->pluck('name') : null;
            },
        ]);
    }

    /**
     * Prepare exception for rendering.
     *
     * @param  \Throwable  $e
     * @return \Throwable
     */
    // @phpstan-ignore-next-line
    public function render($request, Throwable $e)
    {
        // @phpstan-ignore-next-line
        $response = parent::render($request, $e);

        if (!app()->environment(['local', 'testing']) && in_array($response->status(), [500, 503, 404, 403])) {
            // @phpstan-ignore-next-line
            return Inertia::render('Error', ['status' => $response->status()])
                ->toResponse($request)
                ->setStatusCode($response->status());
        } elseif ($response->status() === 419) {
            // @phpstan-ignore-next-line
            return back()->with([
                'message_login' => 'The page expired, please try again.',
            ]);
        }

        return $response;
    }
}
