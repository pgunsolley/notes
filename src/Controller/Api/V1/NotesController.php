<?php
declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Controller\Api\ApiController;
use App\Crud\Listener\FindByIdentityListener;

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
        $this->Crud->addListener('FindByIdentityListener', FindByIdentityListener::class, ['identifierField' => 'sub']);
    }
}
