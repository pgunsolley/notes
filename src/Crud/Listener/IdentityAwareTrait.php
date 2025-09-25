<?php
declare(strict_types=1);

namespace App\Crud\Listener;

use Authentication\IdentityInterface;

trait IdentityAwareTrait
{
    protected function _identity(): IdentityInterface
    {
        return $this->_controller()->Authentication->getIdentity();
    }

    protected function _identifier()
    {
        $identifierField = $this->getConfig('identifierField', null);
        if ($identifierField === null) {
            return $this->_identity()->getIdentifier();
        }

        return $this->_identity()->{$identifierField};
    }
}