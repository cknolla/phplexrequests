<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RequestsIssuesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RequestsIssuesTable Test Case
 */
class RequestsIssuesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RequestsIssuesTable
     */
    public $RequestsIssues;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.requests_issues',
        'app.requests',
        'app.users',
        'app.issues'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('RequestsIssues') ? [] : ['className' => 'App\Model\Table\RequestsIssuesTable'];
        $this->RequestsIssues = TableRegistry::get('RequestsIssues', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RequestsIssues);

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
