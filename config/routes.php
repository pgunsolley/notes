<?php
/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use App\Authentication\AppAuthenticationServiceProvider;
use Authentication\Middleware\AuthenticationMiddleware;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

$crud = fn(array $ignored = []) =>
    static function (RouteBuilder $routes) use ($ignored) {
        $routes->connect('/', ['action' => 'index'], ['_name' => 'index']);
        foreach (['add', 'edit', 'view', 'delete', 'deleteAll'] as $action) {
            if (in_array($action, $ignored)) {
                continue;
            }
            $routes->connect("/$action/*", compact('action'), ['_name' => $action]);
        }
    };

return function (RouteBuilder $routes) use ($crud): void {
    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $routes) use ($crud): void {
        $routes->registerMiddleware('csrf', new CsrfProtectionMiddleware(['httponly' => true]));
        $routes->registerMiddleware('app-authentication', new AuthenticationMiddleware(new AppAuthenticationServiceProvider()));
        $routes->applyMiddleware('csrf');
        $routes->applyMiddleware('app-authentication');

        $routes->redirect('/', ['_name' => 'notes:index']);
        $routes->connect('/login', ['controller' => 'Users', 'action' => 'login'], ['_name' => 'login']);
        $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout'], ['_name' => 'logout']);
        $routes->scope('/notes', ['_namePrefix' => 'notes:', 'controller' => 'Notes'], $crud());
        $routes->scope('/note-tree', ['_namePrefix' => 'note-tree:', 'controller' => 'NoteRelationships'], $crud());
    });

    // TODO: Create REST endpoints for reading notes
    /*
    $routes->prefix('Api', ['_namePrefix' => 'api:'], static function (RouteBuilder $routes) {
        $routes->prefix('V1', ['_namePrefix' => 'v1:'], static function (RouteBuilder $routes) {
            // TODO: Connect API middleware and routes
        });
    });
    */
};
