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

    public function beforeRender()
    {
        $viewVars = $this->_controller->viewBuilder()->getVars();
        if (array_key_exists('associations', $viewVars)) {
            $associations = $viewVars['associations'];
            if (array_key_exists('manyToOne', $associations)) {
                foreach (array_intersect(['Parents', 'Children'], array_keys($associations['manyToOne'])) as $assocName) {
                    $associations['manyToOne'][$assocName]['controller'] = 'Notes';
                }
                $this->_controller()->set(compact('associations'));
            }
        }
    }
}