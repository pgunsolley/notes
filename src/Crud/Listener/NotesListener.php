<?php

declare(strict_types=1);

namespace App\Crud\Listener;

use App\Crud\Listener\IdentityAwareTrait;
use Cake\Event\EventInterface;
use Crud\Listener\BaseListener;

class NotesListener extends BaseListener
{
    use IdentityAwareTrait;

    public function startup()
    {
        $this->_action()->setConfig('scaffold.page_title', 'Notes');
    }

    public function beforeSave(EventInterface $event)
    {
        $entity = $event->getSubject()->entity;
        if ($entity->user_id === null) {
            $entity->user_id = $this->_identifier();
        }
    }
}