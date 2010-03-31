<?php 
/* SVN FILE: $Id$ */
/* User Fixture generated on: 2009-09-19 06:31:24 : 1253334684*/

class UserFixture extends CakeTestFixture {
	var $name = 'User';
	var $table = 'users';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'username' => array('type'=>'string', 'null' => false, 'key' => 'unique'),
		'password' => array('type'=>'string', 'null' => false, 'length' => 40),
		'group_id' => array('type'=>'integer', 'null' => false),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'username' => array('column' => 'username', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'username'  => 'Lorem ipsum dolor sit amet',
		'password'  => 'Lorem ipsum dolor sit amet',
		'group_id'  => 1,
		'created'  => '2009-09-19 06:31:24',
		'modified'  => '2009-09-19 06:31:24'
	));
}
?>