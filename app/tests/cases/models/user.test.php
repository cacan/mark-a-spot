<?php 
/* SVN FILE: $Id$ */
/* User Test cases generated on: 2009-09-19 06:31:24 : 1253334684*/
App::import('Model', 'User');

class UserTestCase extends CakeTestCase {
	var $User = null;
	var $fixtures = array('app.user', 'app.group', 'app.marker', 'app.marker');

	function startTest() {
		$this->User =& ClassRegistry::init('User');
	}

	function testUserInstance() {
		$this->assertTrue(is_a($this->User, 'User'));
	}

	function testUserFind() {
		$this->User->recursive = -1;
		$results = $this->User->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('User' => array(
			'id'  => 1,
			'username'  => 'Lorem ipsum dolor sit amet',
			'password'  => 'Lorem ipsum dolor sit amet',
			'group_id'  => 1,
			'created'  => '2009-09-19 06:31:24',
			'modified'  => '2009-09-19 06:31:24'
		));
		$this->assertEqual($results, $expected);
	}
}
?>