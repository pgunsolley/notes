<?php

declare(strict_types=1);

namespace App\Crud\Listener;

use App\Crud\Listener\IdentityAwareTrait;
use Cake\Event\EventInterface;
use Cake\ORM\Query\SelectQuery;
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
        /** @var \Crud\Listener\RelatedModelsListener $relatedModelsListener */
        $relatedModelsListener = $this->_crud()->listener('relatedModels');
        $relatedModelsListener->relatedModels(['Parents', 'Children']);

        $actionName = $this->_request()->getParam('action');
        if ($actionName === 'view') {
            $this->_action()->setConfig('scaffold.fields_blacklist', ['parents._ids', 'children._ids']);
        }
    }

    public function relatedModel(EventInterface $event)
    {
        $subject = $event->getSubject();
        $query = $subject->query;
        $association = $subject->association;

        if (in_array($association->getName(), ['Parents', 'Children'])) {
            $query->find('byUserId', userId: $this->_identifier());
        }
    }

    public function beforeFind(EventInterface $event)
    {
        $subject = $event->getSubject();
        /** @var \Cake\ORM\Query\SelectQuery $query */
        $query = $subject->query;
        foreach (['Children', 'Parents'] as $assocName) {
            $query->contain($assocName, static function (SelectQuery $query) {
                return $query->select(['id', 'body']);
            });
        }
    }
    
    public function beforeRender()
    {
        $viewVars = $this->_controller->viewBuilder()->getVars();
        if (array_key_exists('associations', $viewVars)) {
            $associations = $viewVars['associations'];
            if (array_key_exists('manyToMany', $associations)) {
                foreach (array_intersect(['Parents', 'Children'], array_keys($associations['manyToMany'])) as $assocName) {
                    $associations['manyToMany'][$assocName]['controller'] = 'Notes';
                }
                $this->_controller()->set(compact('associations'));
            }
        }
    }
}
