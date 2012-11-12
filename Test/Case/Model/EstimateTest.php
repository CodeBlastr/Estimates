<?php
App::uses('Estimate', 'Estimates.Model');

/**
 * Contact Test Case
 *
 */
class EstimateTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
        'plugin.Estimates.Estimate',
        'plugin.Activities.Activity',
        );

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Estimate = ClassRegistry::init('Estimates.Estimate');
		$this->Activity = ClassRegistry::init('Activities.Activity');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Estimate);

		parent::tearDown();
	}

/**
 * test Add method
 *
 * @return void
 */
	public function testSave() {
		$data['Estimate']['total'] = '5000.00';
		$this->Estimate->save($data);
		$result = $this->Estimate->find('first');
		
        $this->assertEqual($result['Estimate']['name'], 'Estimate: 1'); // test auto naming by number works
	}
	
	public function testSaveWithLoggable() {
		$data['Estimate']['total'] = '5000.00';
		$this->Estimate->save($data);
		$result = $this->Activity->read(null, $this->Activity->id);
		
        $this->assertEqual($result['Activity']['action_description'], 'estimate created'); // test that activity is logged
	}
	
}
