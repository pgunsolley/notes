<?php

declare(strict_types=1);

namespace App\Listener\Crud;

use Cake\Event\EventInterface;
use Cake\ORM\Query\SelectQuery;
use Crud\Listener\BaseListener;

class NotesListener extends BaseListener
{
    private ?string $userId;

    public function startup()
    {
        $this->userId = $this->_controller()->Authentication->getIdentifier();
    }

    public function beforePaginate(EventInterface $event)
    {
        $this->modifyQuery($event->getSubject()->query);
    }

    public function beforeFind(EventInterface $event)
    {
        $this->modifyQuery($event->getSubject()->query);
    }

    public function beforeSave(EventInterface $event)
    {
        $entity = $event->getSubject()->entity;
        if ($entity->user_id === null) {
            $entity->user_id = $this->userId;
        }
    }

    protected function modifyQuery(SelectQuery $query): SelectQuery
    {
        return $query->find('byUserId', userId: $this->userId);
    }
}