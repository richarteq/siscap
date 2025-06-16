<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SettingsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SettingsTable Test Case
 */
class SettingsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SettingsTable
     */
    public $Settings;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.settings',
        'app.users',
        'app.roles',
        'app.courses',
        'app.states',
        'app.files',
        'app.instructors',
        'app.teachers',
        'app.participants',
        'app.students',
        'app.answers',
        'app.questions',
        'app.evaluations',
        'app.options',
        'app.responses',
        'app.polls',
        'app.criterions',
        'app.videos',
        'app.schedules',
        'app.tasks',
        'app.presentations',
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
        $config = TableRegistry::exists('Settings') ? [] : ['className' => SettingsTable::class];
        $this->Settings = TableRegistry::get('Settings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Settings);

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
