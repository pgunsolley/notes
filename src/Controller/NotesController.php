<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Notes Controller
 *
 * @property \App\Model\Table\NotesTable $Notes
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 */
class NotesController extends AppController
{
    public function index()
    {
        $this->Authorization->skipAuthorization();
        $this->Crud->execute();
    }
}
