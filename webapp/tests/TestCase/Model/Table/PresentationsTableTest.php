<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PresentationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PresentationsTable Test Case
 */
class PresentationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PresentationsTable
     */
    public $Presentations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.presentations',
        'app.tasks',
        'app.courses',
        'app.states',
        'app.users',
        'app.roles',
        'app.files',
        'app.messages',
        'app.recipients',
        'app.polls',
        'app.questions',
        'app.evaluations',
        'app.answers',
        'app.students',
        'app.participants',
        'app.options',
        'app.responses',
        'app.teachers',
        'app.instructors',
        'app.videos',
        'app.schedules'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Presentations') ? [] : ['className' => PresentationsTable::class];
        $this->Presentations = TableRegistry::get('Presentations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Presentations);

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
