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
            $this->manageFormFields();
            $this->manageTitle();
        }
    }

    public function beforeRender(EventInterface $event)
    {
        if ($this->_crud()->isActionMapped()) {
            $this->manageCrudViewClass();
        }
    }

    protected function manageTitle()
    {
        $this->_action()->setConfig('scaffold.site_title', 'Notes');
    }

    protected function manageSidebarNavigation()
    {
        $this->_action()->setConfig('scaffold.tables', ['notes', 'note_relationships']);
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

    protected function manageFormFields()
    {
        $actionName = $this->_request()->getParam('action');
        $fields = [];
        if (in_array($actionName, ['add', 'edit', 'view'])) {
            $fields = ['user_id', 'created', 'modified'];
        } else if ($actionName === 'index') {
            $fields = ['id', 'user_id', 'created', 'modified'];
        }
        $this->_action()->setConfig('scaffold.fields_blacklist', $fields);
    }

    protected function manageCrudViewClass()
    {
        $viewBuilder = $this->_controller->viewBuilder();
        if ($viewBuilder->getClassName() === null) {
            $viewBuilder->setClassName('CrudView\View\CrudView');
        }
    }
}