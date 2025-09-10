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
        $actionName = $this->request->getParam('action');
        if (in_array($actionName, ['index', 'add'])) {
            $this->Authorization->skipAuthorization();
        }
    }
}
