<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Authentication->allowUnauthenticated(['login']);
        $this->Authorization->skipAuthorization();
    }

    public function login()
    {
        $result = $this->Authentication->getResult();
        if ($result && $result->isValid()) {
            return $this->redirect(['_name' => 'notes:index']);
        }
        if ($this->request->is('post')) {
            $this->Flash->error('Invalid username or password');
        }
    }

    public function logout()
    {
        $this->Authentication->logout();
        return $this->redirect(['_name' => 'login']);
    }
}
