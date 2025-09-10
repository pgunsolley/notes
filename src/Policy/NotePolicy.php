<?php

declare(strict_types=1);

namespace App\Policy;

class NotePolicy
{
    public function __call($_, array $args)
    {
        /** @var \Authorization\Identity $identity */
        $identity = $args[0];

        /** @var \App\Model\Entity\Note $note */
        $note = $args[1];

        return $note->user_id === $identity->id;
    }
}