<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\TrustProxies::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\MarkNotificationAsRead::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'super-admin' => \App\Http\Middleware\SuperAdminAuthenticated::class,
        'admin' => \App\Http\Middleware\AdminAuthenticated::class,
        'driver' => \App\Http\Middleware\DriverAuthenticated::class,
        'customer' => \App\Http\Middleware\CustomerAuthenticated::class,
        'online-rental' => \App\Http\Middleware\OnlineRental::class,
        'walkin-rental' => \App\Http\Middleware\WalkInRental::class,
        'online-reservation' => \App\Http\Middleware\OnlineReservation::class,
        'walkin-reservation' => \App\Http\Middleware\WalkInReservation::class,
        'user-status' => \App\Http\Middleware\ChangeUserStatus::class,
        'getting-started' => \App\Http\Middleware\GettingStarted::class,
        'prevent-back' => \App\Http\Middleware\PreventBackHistory::class,
        'prevent-back-registration-success' => \App\Http\Middleware\RegistrationSuccess::class,
    ];
}
