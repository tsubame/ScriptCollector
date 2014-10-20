<?php
/**
 * NicoLiveFixture
 *
 */
class NicoLiveFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'length' => 11, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => true),
		'url' => array('type' => 'string', 'null' => true),
		'start_date' => array('type' => 'datetime', 'null' => true),
		'created' => array('type' => 'datetime', 'null' => false),
		'modified' => array('type' => 'datetime', 'null' => false),
		'indexes' => array(
			
		),
		'tableParameters' => array()
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'title' => 'Lorem ipsum dolor sit amet',
			'url' => 'Lorem ipsum dolor sit amet',
			'start_date' => '2014-10-20 05:22:10',
			'created' => '2014-10-20 05:22:10',
			'modified' => '2014-10-20 05:22:10'
		),
	);

}
