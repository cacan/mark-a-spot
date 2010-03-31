<?php 
/* SVN FILE: $Id$ */
/* Cat Test cases generated on: 2009-10-07 21:05:31 : 1254942331*/
App::import('Model', 'Cat');

class CatTestCase extends CakeTestCase {
	var $Cat = null;
	var $fixtures = array('app.cat', 'app.parent', 'app.marker', 'app.marker');

	function startTest() {
		$this->Cat =& ClassRegistry::init('Cat');
	}

	function testCatInstance() {
		$this->assertTrue(is_a($this->Cat, 'Cat'));
	}

	function testCatFind() {
		$this->Cat->recursive = -1;
		$results = $this->Cat->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Cat' => array(
			'id'  => 1,
			'parent_id'  => 1,
			'lft'  => 1,
			'rght'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'hex'  => 'Lore'
		));
		$this->assertEqual($results, $expected);
	}
}
?>