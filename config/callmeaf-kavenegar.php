<?php

return [
    'api_key' => '',
    'api_url' => 'https://api.kavenegar.com/v1',
    'patterns' => [
        'verify_otp' => [
            'template' => 'verifyotp',
            'keys' => [
                'token',
                'token2',
                'token3',
            ],
        ],
        'welcome' => [
            'template' => 'welcome',
            'keys' => [
                'token',
                'token2',
                'token3',
            ],
        ],
        'verify_forgot_password_code' => [
            'template' => 'forgot_password_code',
            'keys' => [
                'token',
                'token2',
                'token3',
            ],
        ],
    ],
];
