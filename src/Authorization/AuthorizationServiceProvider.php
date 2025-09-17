<?php
declare(strict_types=1);

namespace App\Authorization;

use Authorization\AuthorizationService;
use Authorization\AuthorizationServiceInterface;
use Authorization\AuthorizationServiceProviderInterface;
use Authorization\Policy\OrmResolver;
use Psr\Http\Message\ServerRequestInterface;

class AuthorizationServiceProvider implements AuthorizationServiceProviderInterface
{
    public function getAuthorizationService(ServerRequestInterface $request): AuthorizationServiceInterface
    {
        return new AuthorizationService(new OrmResolver());
    }
}