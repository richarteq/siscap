<?php
namespace App\Test\TestCase\Controller;

use App\Controller\QuestionsController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\QuestionsController Test Case
 */
class QuestionsControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.questions',
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
        'app.teachers',
        'app.instructors',
        'app.tasks',
        'app.presentations',
        'app.videos',
        'app.schedules',
        'app.options',
        'app.responses'
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
