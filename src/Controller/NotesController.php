<?php
declare(strict_types=1);

namespace App\Controller;

use App\Crud\Listener\EntityAuthorizationListener;
use App\Crud\Listener\FindByIdentityListener;
use App\Crud\Listener\NotesViewListener;
use App\Crud\Listener\SetIdentifierListener;
use Cake\Datasource\Exception\InvalidPrimaryKeyException;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Http\Exception\UnauthorizedException;
use Cake\Utility\Inflector;
use InvalidArgumentException;

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
        if ($this->Crud->isActionMapped()) {
            $this->Crud->addListener('FindByIdentityListener', FindByIdentityListener::class);
            $this->Crud->addListener('SetIdentifierListener', SetIdentifierListener::class);
            $this->Crud->addListener('NotesViewListener', NotesViewListener::class);
            $this->Crud->addListener('EntityAuthorizationListener', EntityAuthorizationListener::class);
        }
    }

    public function unlinkAssociated()
    {
        try {
            /** @var string $id */
            $id = $this->request->getParam('id');

            /** @var string $id */
            $associationName = $this->request->getParam('association');

            /** @var string $id */
            $associatedId = $this->request->getParam('associatedId');

            /** @var \Cake\ORM\Association\BelongsToMany $association */
            $association = $this->Notes->getAssociation(Inflector::pluralize(Inflector::classify($associationName)));
            $target = $this->Notes->get($id);
            $associated = $this->Notes->get($associatedId);
            $this->Authorization->authorize($target);
            $this->Authorization->authorize($associated);

            if ($association->unlink($target, [$associated])) {
                $this->Flash->success(__('{0} has been removed from {1}', $associated->body, $target->body));
            } else {
                $this->Flash->error(__('Unable to remove {0} from {1}', $associated->body, $target->body));
            }
        } catch (InvalidArgumentException|RecordNotFoundException|InvalidPrimaryKeyException|UnauthorizedException) {
            $this->Flash->error(__('Unable to remove {0}', Inflector::singularize($associationName)));
        }

        $this->redirect($this->referer());
    }
}
