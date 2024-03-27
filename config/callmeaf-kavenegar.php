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
    ],
];
