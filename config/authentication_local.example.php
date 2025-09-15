<?php

return [
    'Authentication' => [
        'Api' => [
            'authenticators' => [
                'Authentication.Jwt' => [
                    'algorithm' => 'ES256',
                    'privateKey' => null,
                    'publicKey' => null,
                ],
            ],
        ],
    ],
];
