<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MailgunsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MailgunsTable Test Case
 */
class MailgunsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MailgunsTable
     */
    public $Mailguns;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.mailguns',
        'app.orders'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Mailguns') ? [] : ['className' => MailgunsTable::class];
        $this->Mailguns = TableRegistry::getTableLocator()->get('Mailguns', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Mailguns);

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
