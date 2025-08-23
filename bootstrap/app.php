<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'check_role' => \App\Http\Middleware\CheckRole::class,
            'check_booking_ownership' => \App\Http\Middleware\CheckBookingOwnership::class,
            'admin_or_employee' => \App\Http\Middleware\AdminOrEmployee::class,
            'claude_bypass' => \App\Http\Middleware\ClaudeBypass::class,
            'redirect_based_on_role' => \App\Http\Middleware\RedirectBasedOnRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
