<?php
declare(strict_types=1);

namespace App\Crud\Listener;

use Cake\Event\EventInterface;
use Crud\Listener\BaseListener;

class SetIdentifierListener extends BaseListener
{
    use IdentityAwareTrait;

    public function beforeSave(EventInterface $event)
    {
        $entity = $event->getSubject()->entity;
        if ($entity->user_id === null) {
            $entity->user_id = $this->_identifier();
        }
    }
}