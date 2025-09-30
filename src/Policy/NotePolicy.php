<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Note;
use Authorization\Identity;

class NotePolicy
{
    public function isIdentifierUserId(Identity $identity, Note $note): bool
    {
        return $identity->getIdentifier() === $note->user_id;
    }

    public function canIndex(Identity $identity, Note $note): bool
    {
        return $this->isIdentifierUserId($identity, $note);
    }

    public function canView(Identity $identity, Note $note): bool
    {
        return $this->isIdentifierUserId($identity, $note);
    }

    public function canAdd(Identity $identity, Note $note): bool
    {
        return $this->isIdentifierUserId($identity, $note);
    }

    public function canEdit(Identity $identity, Note $note): bool
    {
        return $this->isIdentifierUserId($identity, $note);
    }

    public function canDelete(Identity $identity, Note $note): bool
    {
        return $this->isIdentifierUserId($identity, $note);
    }

    public function canUnlinkAssociated(Identity $identity, Note $note): bool
    {
        return $this->isIdentifierUserId($identity, $note);
    }
}