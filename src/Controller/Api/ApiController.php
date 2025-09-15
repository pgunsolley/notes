<?php

declare(strict_types=1);

namespace App\Controller\Api;

use Cake\Controller\Controller;
use Cake\View\JsonView;
use Cake\View\XmlView;
use Crud\Controller\ControllerTrait;

class ApiController extends Controller
{
    use ControllerTrait;

    public function viewClasses(): array
    {
        return [JsonView::class, XmlView::class];
    }

    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('Crud.Crud', [
            'actions' => [
                'Crud.Index',
            ],
            'listeners' => [
                'Crud.Api',
            ],
        ]);
    }
}