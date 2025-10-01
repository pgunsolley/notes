<?php

declare(strict_types=1);

namespace App\Crud\Listener;

use Cake\Event\EventInterface;
use Cake\Routing\Router;
use Crud\Listener\BaseListener;
use CrudView\Menu\MenuItem;

/**
 * App-wide CrudView state management
 */
class AppListener extends BaseListener
{
    public function beforeFilter()
    {
        $this->manageUtilityNavigation();
        $this->manageSidebarNavigation();
        $this->manageFormFields();
        $this->manageTitle();
        $this->manageBulkActions();
    }

    public function beforeRender()
    {
        $this->manageCrudViewClass();
    }

    public function beforeRedirect(EventInterface $event)
    {
        $actionName = $this->_request()->getParam('action');
        if ($actionName === 'delete') {
            $event->getSubject()->url = ['action' => 'index'];
        }
    }

    protected function manageBulkActions()
    {
        $this->_action()->setConfig('scaffold.bulk_actions', [
            Router::url(['action' => 'deleteAll']) => __('Delete records'),
        ]);
    }

    protected function manageTitle()
    {
        $this->_action()->setConfig('scaffold.site_title', 'Notes');
    }

    protected function manageSidebarNavigation()
    {
        $this->_action()->setConfig('scaffold.tables', ['notes', 'note_relationships']);
        $this->_action()->setConfig('scaffold.sidebar_navigation', [
            new MenuItem('Notes', ['_name' => 'notes:index']),
        ]);
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