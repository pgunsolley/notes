<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * Notes Controller
 *
 * @property \App\Model\Table\NotesTable $Notes
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 */
class NotesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $userId = $this->Authentication->getIdentifier();
        $this->Crud->on('beforePaginate', function (EventInterface $event) use ($userId) {
            $event->getSubject()->query->where(['user_id' => $userId]);
        });
        $this->Crud->on('afterFind', function (EventInterface $event) {
            $this->Authorization->authorize($event->getSubject()->entity);
        });
        $this->Crud->on('beforeSave', function (EventInterface $event) use ($userId) {
            $entity = $event->getSubject()->entity;
            if ($entity->user_id === null) {
                $entity->user_id = $userId;
            }
        });
        $actionName = $this->request->getParam('action');
        if (in_array($actionName, ['index', 'add'])) {
            $this->Authorization->skipAuthorization();
        }
    }
}
