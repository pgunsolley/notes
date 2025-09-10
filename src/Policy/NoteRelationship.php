<?php

declare(strict_types=1);

namespace App\Policy;

class NoteRelationshipPolicy
{
    public function __call($_, array $args)
    {
        /** @var \Authorization\Identity $identity */
        $identity = $args[0];

        /** @var \App\Model\Entity\NoteRelationship $note */
        $relationship = $args[1];

        return true; // TODO: Add real check
    }
}