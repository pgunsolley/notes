<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Exception\UnauthorizedException;

/**
 * Notes Controller
 *
 * @property \App\Model\Table\NotesTable $Notes
 */
class NotesController extends AppController
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
            $this->Crud->on('beforeSave', static function (EventInterface $event) use ($userId) {
                $entity = $event->getSubject()->entity;
                if ($entity->user_id === null) {
                    $entity->user_id = $userId;
                }
            });
            $actionName = $this->request->getParam('action');
        }
    }
}
