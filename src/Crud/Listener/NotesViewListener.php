<?php

declare(strict_types=1);

namespace App\Crud\Listener;

use App\Crud\Listener\IdentityAwareTrait;
use Crud\Listener\BaseListener;

class NotesViewListener extends BaseListener
{
    use IdentityAwareTrait;

    public function startup()
    {
        $this->_action()->setConfig('scaffold.page_title', 'Notes');
    }
}