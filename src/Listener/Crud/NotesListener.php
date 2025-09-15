<?php

declare(strict_types=1);

namespace App\Listener\Crud;

use Cake\Event\EventInterface;
use Crud\Listener\BaseListener;

class NotesListener extends BaseListener
{
    private ?string $userId;

    public function startup()
    {
        $this->userId = $this->_controller()->Authentication->getIdentifier();
        $action = $this->_action();
        $action->setConfig('scaffold.page_title', 'Notes');
        $actionName = $this->_request()->getParam('action');
        // TODO: Wire associations
    }

    public function beforePaginate(EventInterface $event)
    {
        $event->getSubject()->query->find('byUserId', userId: $this->userId);
    }

    public function beforeFind(EventInterface $event)
    {
        $event->getSubject()->query->find('byUserId', userId: $this->userId);
    }

    public function beforeSave(EventInterface $event)
    {
        $entity = $event->getSubject()->entity;
        if ($entity->user_id === null) {
            $entity->user_id = $this->userId;
        }
    }
}