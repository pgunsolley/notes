<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

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
        $userId = $this->Authentication->getIdentifier();
        $this->Crud->on('beforePaginate', static function (EventInterface $event) use ($userId) {
            // TODO: Load user association; query WHERE userId == $userId only
        });
        $this->Crud->on('beforeFind', function (EventInterface $event) {
            // TODO: Load user association
        });
        $this->Crud->on('afterFind', function (EventInterface $event) use ($userId) {
            // TODO: Apply authorization check
        });
        $this->Crud->action()->setConfig('scaffold.page_title', 'NoteTree');
        $actionName = $this->request->getParam('action');
        if ($actionName === 'index') {
            $this->Crud->action()->setConfig('scaffold.fields', [
                'note_a' => ['title' => 'Parent'],
                'note_b' => ['title' => 'Child'],
            ]);
        }
        if (in_array($actionName, ['index', 'add'])) {
            $this->Authorization->skipAuthorization();
        }
        if (in_array($actionName, ['add', 'view', 'edit'])) {
            $this->Crud->action()->setConfig('scaffold.fields', [
                'note_a' => [
                    'label' => 'Parent',
                    'type' => 'select',
                ],
                'note_b' => [
                    'label' => 'Child',
                    'type' => 'select',
                ],
            ]);
        }
    }
}
