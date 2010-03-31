<?php 
/* SVN FILE: $Id$ */
/* Group Test cases generated on: 2009-09-19 06:30:17 : 1253334617*/
App::import('Model', 'Group');

class GroupTestCase extends CakeTestCase {
	var $Group = null;
	var $fixtures = array('app.group', 'app.user', 'app.user');

	function startTest() {
		$this->Group =& ClassRegistry::init('Group');
	}

	function testGroupInstance() {
		$this->assertTrue(is_a($this->Group, 'Group'));
	}

	function testGroupFind() {
		$this->Group->recursive = -1;
		$results = $this->Group->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Group' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2009-09-19 06:30:17',
			'modified'  => '2009-09-19 06:30:17'
		));
		$this->assertEqual($results, $expected);
	}
}
?>