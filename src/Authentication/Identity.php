<?php
declare(strict_types=1);

namespace App\Authentication;

use Authentication\Identity as AuthenticationIdentity;

class Identity extends AuthenticationIdentity
{
    public function getIdentifier(): array|string|int|null
    {
        return $this->get('id') ?? $this->get('sub');
    }
}