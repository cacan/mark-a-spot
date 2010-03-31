<?php 
/* SVN FILE: $Id$ */
/* Cat Fixture generated on: 2009-10-07 21:05:23 : 1254942323*/

class CatFixture extends CakeTestFixture {
	var $name = 'Cat';
	var $table = 'cats';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'parent_id' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'lft' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'rght' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'name' => array('type'=>'string', 'null' => true),
		'hex' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 6),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'parent_id'  => 1,
		'lft'  => 1,
		'rght'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'hex'  => 'Lore'
	));
}
?>