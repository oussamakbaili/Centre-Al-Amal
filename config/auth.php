<?php

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    // ===========================
    //         GUARDS
    // ===========================

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],

        'enseignant' => [
            'driver' => 'session',
            'provider' => 'enseignants',
        ],

        'superadmin' => [
            'driver' => 'session',
            'provider' => 'superadmins',
        ],

        'etudiant' => [
            'driver' => 'session',
            'provider' => 'etudiants',
        ],
    ],

    // ===========================
    //        PROVIDERS
    // ===========================

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],

        'enseignants' => [
            'driver' => 'eloquent',
            'model' => App\Models\Enseignant::class,
        ],

        'superadmins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Superadmin::class,
        ],

        'etudiants' => [
            'driver' => 'eloquent',
            'model' => App\Models\Etudiant::class,
        ],
    ],

    // ===========================
    //     RESETTING PASSWORDS
    // ===========================

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'admins' => [
            'provider' => 'admins',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'enseignants' => [
            'provider' => 'enseignants',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'superadmins' => [
            'provider' => 'superadmins',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'etudiants' => [
            'provider' => 'etudiants',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    // ===========================
    // CONFIRMATION TIMEOUT
    // ===========================

    'password_timeout' => 10800,

];
