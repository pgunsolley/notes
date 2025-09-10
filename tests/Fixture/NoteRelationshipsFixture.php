<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * NoteRelationshipsFixture
 */
class NoteRelationshipsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 'd11cebfc-6cfb-46a2-b8c2-0bce3e3128b4',
                'note_a' => '4b560282-dbf6-4ba2-908a-5c1a656c4729',
                'note_b' => '275c462b-72aa-49fe-bec3-93c3f8ded5e4',
                'created' => '2025-09-10 05:49:20',
                'modified' => '2025-09-10 05:49:20',
            ],
        ];
        parent::init();
    }
}
