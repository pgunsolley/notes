<?php
declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Controller\Api\ApiController;
use App\Crud\Listener\EntityAuthorizationListener;
use App\Crud\Listener\FindByIdentityListener;
use App\Crud\Listener\Notes\FindWithChildrenListener;
use App\Crud\Listener\SetIdentifierListener;

/**
 * Notes Controller
 *
 * @property \App\Model\Table\NotesTable $Notes
 */
class NotesController extends ApiController
{
    public function initialize(): void
    {
        parent::initialize();
        if ($this->Crud->isActionMapped()) {
            $this->Crud->addListener(FindByIdentityListener::class, FindByIdentityListener::class);
            $this->Crud->addListener(FindWithChildrenListener::class, FindWithChildrenListener::class);
            $this->Crud->addListener(SetIdentifierListener::class, SetIdentifierListener::class);
            $this->Crud->addListener(EntityAuthorizationListener::class, EntityAuthorizationListener::class);
        }
    }
}
