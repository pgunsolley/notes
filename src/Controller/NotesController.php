<?php
declare(strict_types=1);

namespace App\Controller;

use App\Crud\Listener\FindByIdentityListener;
use App\Crud\Listener\NotesListener;

/**
 * Notes Controller
 *
 * @property \App\Model\Table\NotesTable $Notes
 */
class NotesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Crud->addListener('FindByIdentityListener', FindByIdentityListener::class);
        $this->Crud->addListener('NotesListener', NotesListener::class);
    }
}
