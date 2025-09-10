<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NoteRelationshipsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NoteRelationshipsTable Test Case
 */
class NoteRelationshipsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\NoteRelationshipsTable
     */
    protected $NoteRelationships;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.NoteRelationships',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('NoteRelationships') ? [] : ['className' => NoteRelationshipsTable::class];
        $this->NoteRelationships = $this->getTableLocator()->get('NoteRelationships', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->NoteRelationships);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\NoteRelationshipsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
