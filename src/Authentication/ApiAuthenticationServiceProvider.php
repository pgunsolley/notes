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
        // TODO: Implement form and jwt authentication
    }
}