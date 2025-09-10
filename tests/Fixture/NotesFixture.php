<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * NotesFixture
 */
class NotesFixture extends TestFixture
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
                'id' => '70d071a0-00a0-44c4-963c-dfd9c1e28202',
                'user_id' => '29e0b5cd-8316-4450-9240-b3481af193aa',
                'body' => 'Lorem ipsum dolor sit amet',
                'created' => '2025-09-10 05:48:45',
                'modified' => '2025-09-10 05:48:45',
            ],
        ];
        parent::init();
    }
}
