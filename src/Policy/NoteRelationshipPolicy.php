<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\NoteRelationship;
use Authorization\Identity;
use Cake\ORM\TableRegistry;

class NoteRelationshipPolicy
{
    protected function areParentAndChildNotesUserIdIdentifier(Identity $identity, NoteRelationship $noteRelationship): bool
    {
        if ($noteRelationship->note_a === null || $noteRelationship->note_b === null) {
            return false;
        }

        $notePolicy = new NotePolicy();
        $notesTable = TableRegistry::getTableLocator()->get('Notes');
        $parentNote = $noteRelationship->get('parent') ?? $notesTable->get($noteRelationship->note_a);
        $childNote = $noteRelationship->get('child') ?? $notesTable->get($noteRelationship->note_b);
        
        return $notePolicy->isIdentifierUserId($identity, $parentNote) && $notePolicy->isIdentifierUserId($identity, $childNote);
    }

    public function canIndex(Identity $identity, NoteRelationship $noteRelationship): bool
    {
        return $this->areParentAndChildNotesUserIdIdentifier($identity, $noteRelationship);
    }

    public function canView(Identity $identity, NoteRelationship $noteRelationship): bool
    {
        return $this->areParentAndChildNotesUserIdIdentifier($identity, $noteRelationship);
    }

    public function canAdd(Identity $identity, NoteRelationship $noteRelationship): bool
    {
        return $this->areParentAndChildNotesUserIdIdentifier($identity, $noteRelationship);
    }

    public function canEdit(Identity $identity, NoteRelationship $noteRelationship): bool
    {
        return $this->areParentAndChildNotesUserIdIdentifier($identity, $noteRelationship);
    }

    public function canDelete(Identity $identity, NoteRelationship $noteRelationship): bool
    {
        return $this->areParentAndChildNotesUserIdIdentifier($identity, $noteRelationship);
    }
}