<?php

declare(strict_types=1);

namespace App\Listener\Crud;

use Cake\Event\EventInterface;
use Cake\ORM\Query\SelectQuery;
use Crud\Listener\BaseListener;

class NoteRelationshipsListener extends BaseListener
{
    protected readonly ?string $userId;

    public function startup(): void
    {
        $this->userId = $this->_controller()->Authentication->getIdentifier();
        $action = $this->_action();
        $action->setConfig('scaffold.page_title', 'NoteTree');
        $actionName = $this->_request()->getParam('action');
        if ($actionName === 'index') {
            $action->setConfig('scaffold.fields', [
                'parent.body' => ['title' => 'Parent'],
                'child.body' => ['title' => 'Child'],
            ]);
        }
        if (in_array($actionName, ['add', 'view', 'edit'])) {
            $action->setConfig('relatedModels', false);
            $notes = $this
                ->_controller()
                ->fetchTable('Notes')
                ->find('list')
                ->find('byUserId', userId: $this->userId)
                ->orderBy('body');
            $action->setConfig('scaffold.fields', [
                'note_a' => [
                    'label' => 'Parent',
                    'type' => 'select',
                    'options' => $notes,
                ],
                'note_b' => [
                    'label' => 'Child',
                    'type' => 'select',
                    'options' => $notes,
                ],
            ]);
        }
    }

    public function beforePaginate(EventInterface $event): void
    {
        $this->modifyQuery($event->getSubject()->query);
    }

    public function beforeFind(EventInterface $event): void
    {
        $this->modifyQuery($event->getSubject()->query);
    }

    protected function modifyQuery(SelectQuery $query): SelectQuery
    {
        return $query->find('byUserId', userId: $this->userId);
    }
}