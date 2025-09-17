<?php

declare(strict_types=1);

namespace App\Authentication;

use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Identifier\AbstractIdentifier;
use Cake\Routing\Router;
use Psr\Http\Message\ServerRequestInterface;

class AppAuthenticationServiceProvider implements AuthenticationServiceProviderInterface
{
    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    {
        $fields = [
            AbstractIdentifier::CREDENTIAL_USERNAME => 'email',
            AbstractIdentifier::CREDENTIAL_PASSWORD => 'password',
        ];
        $loginUrl = Router::url(['_name' => 'login']);
        $passwordIdentifier = [
            'Authentication.Password' => [
                'fields' => $fields,
            ],
        ];
        return new AuthenticationService([
            'identityClass' => Identity::class,
            'unauthenticatedRedirect' => Router::url($loginUrl),
            'queryParam' => 'redirect',
            'authenticators' => [
                'Authentication.Session' => [
                    'identifier' => $passwordIdentifier,
                ],
                'Authentication.Form' => [
                    'identifier' => $passwordIdentifier,
                    'fields' => $fields,
                    'loginUrl' => $loginUrl,
                ],
            ],
        ]);
    }
}