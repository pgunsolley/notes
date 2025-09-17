<?php
declare(strict_types=1);

namespace App\Crud\Listener;

use Cake\Event\EventInterface;
use Cake\ORM\Query\SelectQuery;
use Crud\Listener\BaseListener;

class FindByIdentityListener extends BaseListener
{
    use IdentityAwareTrait;

    public function beforeFind(EventInterface $event)
    {
        $this->callFinder($event->getSubject()->query);
    }

    public function beforePaginate(EventInterface $event)
    {
        $this->callFinder($event->getSubject()->query);
    }

    protected function callFinder(SelectQuery $query): SelectQuery
    {
        return $query->find('byUserId', userId: $this->_identifier());
    }
}