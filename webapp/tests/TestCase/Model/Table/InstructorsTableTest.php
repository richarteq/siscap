<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InstructorsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InstructorsTable Test Case
 */
class InstructorsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\InstructorsTable
     */
    public $Instructors;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.instructors',
        'app.teachers',
        'app.users',
        'app.roles',
        'app.courses',
        'app.files',
        'app.participants',
        'app.students',
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
        $config = TableRegistry::exists('Instructors') ? [] : ['className' => InstructorsTable::class];
        $this->Instructors = TableRegistry::get('Instructors', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Instructors);

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
