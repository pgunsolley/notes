<?php
declare(strict_types=1);

namespace App\Controller;

use App\Crud\Listener\FindByIdentityListener;
use App\Crud\Listener\NoteRelationshipsViewListener;

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
        $this->Crud->addListener('FindByIdentityListener', FindByIdentityListener::class);
        $this->Crud->addListener('NoteRelationshipsViewListener', NoteRelationshipsViewListener::class);
    }
}
