<?php

return [
    'facebook' => [
        'client_id' => env('FACEBOOK_APP_ID'),
        'client_secret' => env('FACEBOOK_APP_SECRET'),
        'redirect' => env('APP_URL') . '/connected/facebook',
        // https://developers.facebook.com/docs/facebook-login/permissions
        'scopes' => [
            'public_profile',
            'email',
        ],
        'version' => '2.10',
    ],
];
