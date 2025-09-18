<?php
declare(strict_types=1);

namespace App\Crud\Listener;

use Cake\Event\EventInterface;
use Crud\Listener\BaseListener;

class EntityAuthorizationListener extends BaseListener
{
    protected array $_defaultConfig = [
        'skip' => [],
    ];

    public function implementedEvents(): array
    {
        return array_merge(
            array_fill_keys([
                'Crud.beforeFilter',
                'Crud.afterPaginate',
                'Crud.afterFind',
                'Crud.beforeSave',
                'Crud.beforeDelete',
            ], 'handleAuthorization'),
        );
    }

    public function handleAuthorization(EventInterface $event): void
    {
        $subject = $event->getSubject();
        if (property_exists($subject, 'entity')) {
            $entities = [$subject->entity];
        } else if (property_exists($subject, 'entities')) {
            $entities = $subject->entities;
        } else {
            $entities = null;
        }

        if ($entities === null || $this->isActionSkipped()) {
            $this->_controller()->Authorization->skipAuthorization();
        } else {
            foreach ($entities as $entity) {
                $this->_controller()->Authorization->authorize($entity);
            }
        }
    }

    protected function isActionSkipped(): bool
    {
        $skip = $this->getConfig('skip', []);
        if (is_string($skip)) {
            $skip = [$skip];
        }

        return in_array($this->_request()->getParam('action'), $skip);
    }
}