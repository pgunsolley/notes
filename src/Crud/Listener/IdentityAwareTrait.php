<?php
declare(strict_types=1);

namespace App\Crud\Listener;

use Authentication\IdentityInterface;
use Exception;

trait IdentityAwareTrait
{
    protected ?IdentityInterface $identity = null;

    public function beforeFilter(): void
    {
        $this->identity = $this->_controller()->Authentication->getIdentity();
    }

    protected function _identity(): IdentityInterface
    {
        if ($this->identity === null) {
            throw new Exception('Identity is not set');
        }

        return $this->identity;
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