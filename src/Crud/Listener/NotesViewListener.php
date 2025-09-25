<?php

declare(strict_types=1);

namespace App\Crud\Listener;

use App\Crud\Listener\IdentityAwareTrait;
use Cake\Event\EventInterface;
use Crud\Listener\BaseListener;

class NotesViewListener extends BaseListener
{
    use IdentityAwareTrait;

    public function implementedEvents(): array
    {
        return parent::implementedEvents() + ['Crud.relatedModel' => 'relatedModel'];
    }

    public function startup()
    {
        $this->_action()->setConfig('scaffold.page_title', 'Notes');
    }

    public function relatedModel(EventInterface $event)
    {
        $subject = $event->getSubject();
        $query = $subject->query;
        $association = $subject->association;

        if ($association->getName() === 'Children') {
            $query->find('byUserId', userId: $this->_identifier());
        }
    }

    public function beforeRender(EventInterface $event)
    {
        $viewVars = $this->_controller->viewBuilder()->getVars();
        if (array_key_exists('associations', $viewVars)) {
            $associations = $viewVars['associations'];
            if (array_key_exists('manyToMany', $associations)) {
                if (array_key_exists('Children', $associations['manyToMany'])) {
                    $associations['manyToMany']['Children']['controller'] = 'Notes';
                    $this->_controller()->set(compact('associations'));
                }
            }
        }
    }
}
