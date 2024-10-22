<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Illuminate\Routing\Middleware\SubstituteBindings;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php', // Include the api routes here
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Define api middleware group
        $middleware->api(append: [
            EnsureFrontendRequestsAreStateful::class, // Sanctum for token-based authentication
            'throttle:api', // Apply rate-limiting to API requests
            SubstituteBindings::class, // Route model binding
        ]);

        // Define other middleware groups here if needed
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
