<?php
declare(strict_types=1);

namespace App\Controller;

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
        // TODO: Load users in queries
        // TODO: Apply query to search for owned only
        // TODO: apply authorization checks
        $actionName = $this->request->getParam('action');
        if (in_array($actionName, ['index', 'add'])) {
            $this->Authorization->skipAuthorization();
        }
    }
}
