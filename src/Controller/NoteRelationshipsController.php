<?php
declare(strict_types=1);

namespace App\Controller;

use App\Listener\Crud\NoteRelationshipsListener;

/**
 * NoteRelationships Controller
 *
 * @property \App\Model\Table\NoteRelationshipsTable $NoteRelationships
 */
class NoteRelationshipsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Crud->addListener('NoteRelationshipsListener', NoteRelationshipsListener::class);
    }
}
