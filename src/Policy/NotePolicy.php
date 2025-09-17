<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Note;
use Authorization\Identity;

class NotePolicy
{
    protected function identifierIsUserId(Identity $identity, Note $note): bool
    {
        return $identity->getIdentifier() === $note->user_id;
    }

    public function canEdit(Identity $identity, Note $note): bool
    {
        return $this->identifierIsUserId($identity, $note);
    }

    public function canDelete(Identity $identity, Note $note): bool
    {
        return $this->identifierIsUserId($identity, $note);
    }
}