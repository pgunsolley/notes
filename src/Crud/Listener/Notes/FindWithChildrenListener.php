<?php
declare(strict_types=1);

namespace App\Crud\Listener\Notes;

use Cake\Event\EventInterface;
use Cake\ORM\Query\SelectQuery;
use Crud\Listener\BaseListener;

class FindWithChildrenListener extends BaseListener
{
    public function beforeFind(EventInterface $event)
    {
        $this->callFinder($event->getSubject()->query);
    }

    public function beforePaginate(EventInterface $event)
    {
        $this->callFinder($event->getSubject()->query);
    }

    protected function callFinder(SelectQuery $query)
    {
        return $query->find('withChildren', depth: (int)$this->_request()->getQuery('depth', 0));
    }
}