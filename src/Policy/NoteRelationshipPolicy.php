<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\NoteRelationship;
use Authorization\Identity;

class NoteRelationshipPolicy
{
    public function canIndex(Identity $identity, NoteRelationship $noteRelationship): bool
    {
        return true;
    }

    public function canEdit(Identity $identity, NoteRelationship $noteRelationship): bool
    {

    }

    public function canDelete(Identity $identity, NoteRelationship $noteRelationship): bool
    {

    }
}