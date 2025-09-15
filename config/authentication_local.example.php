<?php

return [
    'Authentication' => [
        'Api' => [
            'algorithm' => 'ES256',
            'expiration' => time() + 60,
            'privateKey' => null,
            'publicKey' => null,
        ],
    ],
];
