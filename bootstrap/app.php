<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders()
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Enregistrer les alias de middleware
        $middleware->alias([
            'auth.patient' => \App\Http\Middleware\CheckPatient::class,
            'auth.medecin' => \App\Http\Middleware\CheckMedecin::class,
            'auth.hopital' => \App\Http\Middleware\CheckHopital::class,
            'auth.pharmacie' => \App\Http\Middleware\CheckPharmacie::class,
            'auth.admin' => \App\Http\Middleware\CheckAdmin::class,
        ]);
        
        // PAS de $middleware->web() ou $middleware->group() 
        // Laravel 12 gère ça automatiquement
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();