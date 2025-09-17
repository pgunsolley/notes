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
                'Crud.beforeSave',
                'Crud.afterFind',
            ], 'handleAuthorization'),
        );
    }

    public function handleAuthorization(EventInterface $event): void
    {
        $subject = $event->getSubject();
        $target = $subject->entity ?? null;

        if ($target === null || $this->isActionSkipped()) {
            $this->_controller()->Authorization->skipAuthorization();
        } else {
            $this->_controller()->Authorization->authorize($target);
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