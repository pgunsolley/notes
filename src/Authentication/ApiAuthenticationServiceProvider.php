<?php

declare(strict_types=1);

namespace App\Authentication;

use App\Exception\MissingConfigurationException;
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
        $loginUrl = Router::url(['_name' => 'api:v1:authenticate']);
        $passwordIdentifier = [
            'Authentication.Password' => [
                'fields' => $fields,
            ],
        ];
        $config = Configure::read('Authentication.Api');
        foreach (['publicKey', 'algorithm'] as $key) {
            if (!array_key_exists($key, $config)) {
                throw new MissingConfigurationException($key);
            }
        }
        return new AuthenticationService([
            'authenticators' => [
                'Authentication.Jwt' => [
                    'identifier' => 'Authentication.JwtSubject',
                    'secretKey' => $config['publicKey'],
                    'algorithm' => $config['algorithm'],
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