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
        $association = $subject->association;
        
        // TODO: Refactor IdentifierAwareTrait
    }
}
