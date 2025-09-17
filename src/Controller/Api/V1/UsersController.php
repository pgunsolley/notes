<?php
declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Controller\Api\ApiController;
use Cake\Core\Configure;
use Firebase\JWT\JWT;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends ApiController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Authentication->allowUnauthenticated(['authenticate']);
    }

    public function authenticate()
    {
        $result = $this->Authentication->getResult();
        dd($result);
        if ($result->isValid()) {
            $algorithm = Configure::readOrFail('Authentication.Api.algorithm');
            $privateKey = Configure::readOrFail('Authentication.Api.privateKey');
            $expiration = Configure::readOrFail('Authentication.Api.expiration');
            $user = $result->getData();
            $payload = [
                'iss' => $this->request->domain(),
                'sub' => $user->id,
                'exp' => $expiration,
            ];
            $json = ['token' => JWT::encode($payload, $privateKey, $algorithm)];
        } else {
            $this->response = $this->response->withStatus(401);
            $json = [];
        }
        $this->set(compact('json'));
        $this->viewBuilder()->setOption('serialize', 'json');
    }
}
