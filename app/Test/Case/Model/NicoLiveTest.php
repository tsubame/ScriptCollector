<?php
App::uses('NicoLive', 'Model');

/**
 * NicoLive Test Case
 *
 */
class NicoLiveTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		//'app.nico_live'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->NicoLive = ClassRegistry::init('NicoLive');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->NicoLive);

		parent::tearDown();
	}

	/**
	 * getStartDates 正常系
	 */
	public function testGetStartDates() {
		echo "hello!";
	}
	
}
