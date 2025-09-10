<?php

declare(strict_types=1);

namespace App\Listener;

use Cake\Event\EventInterface;
use Crud\Listener\BaseListener;
use CrudView\Menu\MenuItem;

/**
 * App-wide CrudView state management
 */
class CrudViewListener extends BaseListener
{
    public function beforeFilter(EventInterface $event)
    {
        if ($this->_crud()->isActionMapped()) {
            $this->manageUtilityNavigation();
            $this->manageSidebarNavigation();
        }
    }

    public function beforeRender(EventInterface $event)
    {
        if ($this->_crud()->isActionMapped()) {
            $this->manageCrudViewClass();
        }
    }

    protected function manageSidebarNavigation()
    {
        // Omit users
        $this->_action()->setConfig('scaffold.tables', ['notes']);
    }

    protected function manageUtilityNavigation()
    {
        $identity = $this->_request()->getAttribute('identity');
        $items = [];
        if ($identity === null) {
            $items[] = new MenuItem('Login', ['_name' => 'login']);
        } else {
            $items[] = new MenuItem('Logout', ['_name' => 'logout']);
        }
        $this->_action()->setConfig('scaffold.utility_navigation', $items);
    }

    protected function manageCrudViewClass()
    {
        $viewBuilder = $this->_controller->viewBuilder();
        if ($viewBuilder->getClassName() === null) {
            $viewBuilder->setClassName('CrudView\View\CrudView');
        }
    }
}