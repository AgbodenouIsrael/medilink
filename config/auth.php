<?php

return [
    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'patient' => [
            'driver' => 'session',
            'provider' => 'patients',
        ],

        'medecin' => [
            'driver' => 'session',
            'provider' => 'medecins',
        ],

        'hopital' => [
            'driver' => 'session',
            'provider' => 'hopitals',
        ],

        'pharmacie' => [
            'driver' => 'session',
            'provider' => 'pharmacies',
        ],

        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
    ],

    'providers' => [ // UNE SEULE SECTION providers !
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'patients' => [
            'driver' => 'eloquent',
            'model' => App\Models\Patient::class,
        ],

        'medecins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Medecin::class,
        ],

        'hopitals' => [
            'driver' => 'eloquent',
            'model' => App\Models\Hopital::class,
        ],

        'pharmacies' => [
            'driver' => 'eloquent',
            'model' => App\Models\Pharmacie::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),
];