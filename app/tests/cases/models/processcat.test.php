<?php 
/* SVN FILE: $Id$ */
/* Processcat Test cases generated on: 2009-10-07 21:07:21 : 1254942441*/
App::import('Model', 'Processcat');

class ProcesscatTestCase extends CakeTestCase {
	var $Processcat = null;
	var $fixtures = array('app.processcat', 'app.parent', 'app.marker', 'app.marker');

	function startTest() {
		$this->Processcat =& ClassRegistry::init('Processcat');
	}

	function testProcesscatInstance() {
		$this->assertTrue(is_a($this->Processcat, 'Processcat'));
	}

	function testProcesscatFind() {
		$this->Processcat->recursive = -1;
		$results = $this->Processcat->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Processcat' => array(
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