<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EvaluationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EvaluationsTable Test Case
 */
class EvaluationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EvaluationsTable
     */
    public $Evaluations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.evaluations',
        'app.courses',
        'app.states',
        'app.users',
        'app.roles',
        'app.files',
        'app.messages',
        'app.recipients',
        'app.polls',
        'app.criterions',
        'app.students',
        'app.participants',
        'app.answers',
        'app.questions',
        'app.options',
        'app.responses',
        'app.teachers',
        'app.instructors',
        'app.tasks',
        'app.presentations',
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
        $config = TableRegistry::exists('Evaluations') ? [] : ['className' => EvaluationsTable::class];
        $this->Evaluations = TableRegistry::get('Evaluations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Evaluations);

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
