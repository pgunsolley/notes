<?php

declare(strict_types=1);

namespace App\Authentication;

use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Cake\Core\Configure;
use Psr\Http\Message\ServerRequestInterface;
use Authentication\Identifier\AbstractIdentifier;
use Cake\Routing\Router;

class ApiAuthenticationServiceProvider implements AuthenticationServiceProviderInterface
{
    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    {
        $fields = [
            AbstractIdentifier::CREDENTIAL_USERNAME => 'email',
            AbstractIdentifier::CREDENTIAL_PASSWORD => 'password',
        ];
        return new AuthenticationService([
            'authenticators' => [
                'Authentication.Jwt' => [
                    'identifier' => 'Authentication.JwtSubject',
                    'secretKey' => Configure::readOrFail('Authentication.Api.publicKey'),
                    'algorithm' => Configure::readOrFail('Authentication.Api.algorithm'),
                ],
                'Authentication.Form' => [
                    'identifier' => [
                        'Authentication.Password' => [
                            'fields' => $fields,
                        ],
                    ],
                    'fields' => $fields,
                    'loginUrl' => Router::url(['_name' => 'api:v1:authenticate']),
                ],
            ],
        ]);
    }
}