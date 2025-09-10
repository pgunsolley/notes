<?php
declare(strict_types=1);

namespace App\Controller;

use App\Listener\CrudViewListener;
use Crud\Controller\ControllerTrait;

/**
 * Notes Controller
 *
 * @property \App\Model\Table\NotesTable $Notes
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 */
class NotesController extends AppController
{
    use ControllerTrait;

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Crud.Crud', [
            'actions' => [
                'Crud.Index',
                'Crud.View',
                'Crud.Add',
                'Crud.Edit',
                'Crud.Delete',
            ],
            'listeners' => [
                'CrudView.View',
                'Crud.Redirect',
                'Crud.RelatedModels',
                CrudViewListener::class,
            ],
        ]);
    }

    public function index()
    {
        $this->Authorization->skipAuthorization();
        $this->Crud->execute();
    }
}
