<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\ORM\Query\SelectQuery;

/**
 * NoteRelationships Controller
 *
 * @property \App\Model\Table\NoteRelationshipsTable $NoteRelationships
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 */
class NoteRelationshipsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        if ($this->Crud->isActionMapped()) {
            $userId = $this->Authentication->getIdentifier();
            $this->Crud->on('beforePaginate', static function (EventInterface $event) use ($userId) {
                $event->getSubject()->query->find('byUserId', userId: $userId);
            });
            $this->Crud->on('beforeFind', function (EventInterface $event) use ($userId) {
                $event->getSubject()->query->find('byUserId', userId: $userId);
            });
            $action = $this->Crud->action();
            $action->setConfig('scaffold.page_title', 'NoteTree');
            $actionName = $this->request->getParam('action');
            if ($actionName === 'index') {
                $action->setConfig('scaffold.fields', [
                    'note_a' => ['title' => 'Parent'],
                    'note_b' => ['title' => 'Child'],
                ]);
            }
            if (in_array($actionName, ['index', 'add'])) {
                $this->Authorization->skipAuthorization();
            }
            if (in_array($actionName, ['add', 'view', 'edit'])) {
                $action->setConfig('relatedModels', false);
                $notes = $this->fetchTable('Notes')->find('list')->find('byUserId', userId: $userId);
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
}
