<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateNoteRelationships extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     *
     * @return void
     */
    public function change(): void
    {
        $this
            ->table('note_relationships', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('note_a', 'uuid', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('note_b', 'uuid', [
                'default' => null,
                'null' => false,
            ])
            ->addForeignKey('note_a', 'notes', 'id', [
                'delete' => 'cascade',
            ])
            ->addForeignKey('note_b', 'notes', 'id', [
                'delete' => 'cascade',
            ])
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->create();
    }
}
