<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ParticipantsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ParticipantsTable Test Case
 */
class ParticipantsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ParticipantsTable
     */
    public $Participants;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.participants',
        'app.students',
        'app.users',
        'app.roles',
        'app.courses',
        'app.files',
        'app.instructors',
        'app.teachers',
        'app.polls',
        'app.videos',
        'app.messages',
        'app.recipients'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Participants') ? [] : ['className' => ParticipantsTable::class];
        $this->Participants = TableRegistry::get('Participants', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Participants);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
