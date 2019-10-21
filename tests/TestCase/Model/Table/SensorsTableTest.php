<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SensorsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SensorsTable Test Case
 */
class SensorsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SensorsTable
     */
    public $Sensors;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Sensors'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Sensors') ? [] : ['className' => SensorsTable::class];
        $this->Sensors = TableRegistry::getTableLocator()->get('Sensors', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Sensors);

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
}
