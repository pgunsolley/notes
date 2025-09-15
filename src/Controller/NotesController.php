<?php
declare(strict_types=1);

namespace App\Controller;

use App\Listener\Crud\NotesListener;

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
        $this->Crud->addListener('NotesListener', NotesListener::class);
    }
}
