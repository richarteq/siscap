<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CoursesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CoursesTable Test Case
 */
class CoursesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CoursesTable
     */
    public $Courses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.courses',
        'app.states',
        'app.users',
        'app.roles',
        'app.files',
        'app.messages',
        'app.recipients',
        'app.polls',
        'app.questions',
        'app.answers',
        'app.participants',
        'app.students',
        'app.teachers',
        'app.instructors',
        'app.videos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Courses') ? [] : ['className' => CoursesTable::class];
        $this->Courses = TableRegistry::get('Courses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Courses);

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
