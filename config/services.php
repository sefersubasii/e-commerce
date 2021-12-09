<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
     */

    'mailgun'   => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses'       => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe'    => [
        'model'  => App\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook'  => [
        'client_id'     => '283409496176633',
        'client_secret' => '88ccfa821bc4e9296b983492db9a889d',
        'redirect'      => 'https://www.marketpaketi.com.tr/callback/facebook',
    ],

    'google'    => [
        'client_id'     => '397892848936-u1k2gqima0k7v7s05mmfhlts46b3en6u.apps.googleusercontent.com',
        'client_secret' => 'xOU0JgLr5XlhEsyTLnPXWGqE',
        'redirect'      => 'https://www.marketpaketi.com.tr/callback/google',
    ]
];
