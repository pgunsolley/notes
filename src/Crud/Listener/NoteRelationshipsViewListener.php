<?php

declare(strict_types=1);

namespace App\Crud\Listener;

use App\Crud\Listener\IdentityAwareTrait;
use Crud\Listener\BaseListener;

class NoteRelationshipsViewListener extends BaseListener
{
    use IdentityAwareTrait;

    public function startup(): void
    {
        $action = $this->_action();
        $action->setConfig('scaffold.page_title', 'Relationships');
        $actionName = $this->_request()->getParam('action');

        if ($actionName === 'index') {
            $action->setConfig('scaffold.fields', [
                'parent.body' => ['title' => 'Parent'],
                'child.body' => ['title' => 'Child'],
            ]);
        }

        if (in_array($actionName, ['index', 'view'])) {
            $action->setConfig('scaffold.actions', [
                'view' => ['url' => ['_name' => 'relationships:view']],
                'edit' => ['url' => ['_name' => 'relationships:edit']],
                'delete' => ['url' => ['_name' => 'relationships:delete']],
            ]);
        }

        if (in_array($actionName, ['add', 'view', 'edit'])) {
            $action->setConfig('relatedModels', false);
            $notes = $this
                ->_controller()
                ->fetchTable('Notes')
                ->find('list')
                ->find('byUserId', userId: $this->_identifier())
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
}