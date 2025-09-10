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
            // TODO: Make sure associations are right, then query based on user_id
        });
        $this->Crud->on('afterFind', function (EventInterface $event) use ($userId) {
            // TODO: Apply authorization check
        });

        // FIXME: Not updating heading
        $this->Crud->action()->setConfig('scaffold.action_name', 'NoteTree');
        
        $actionName = $this->request->getParam('action');
        if ($actionName === 'index') {
            // FIXME: Not altering column names
            $this->Crud->action()->setConfig('scaffold.fields', [
                'note_a' => ['label' => 'Parent'],
                'note_b' => ['label' => 'Child'],
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
