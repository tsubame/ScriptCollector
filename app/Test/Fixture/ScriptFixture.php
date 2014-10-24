<?php
/**
 * ScriptFixture
 *
 */
class ScriptFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'length' => 11, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => true),
		'url' => array('type' => 'string', 'null' => true),
		'people_count' => array('type' => 'integer', 'null' => true),
		'man_count　' => array('type' => 'integer', 'null' => true),
		'woman_count' => array('type' => 'integer', 'null' => true),
		'other_count　' => array('type' => 'integer', 'null' => true),
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
			'people_count' => 1,
			'man_count　' => 1,
			'woman_count' => 1,
			'other_count　' => 1,
			'created' => '2014-10-21 15:48:47',
			'modified' => '2014-10-21 15:48:47'
		),
	);

}
