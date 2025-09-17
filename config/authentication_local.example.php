<?php

return [
    'Authentication' => [
        'Api' => [
            'algorithm' => 'RS256',
            'expiration' => time() + 60,
            'privateKey' => null,
            'publicKey' => null,
        ],
    ],
];
