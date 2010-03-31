<?php 
/* SVN FILE: $Id$ */
/* ProcesscatsController Test cases generated on: 2009-10-07 21:12:30 : 1254942750*/
App::import('Controller', 'Processcats');

class TestProcesscats extends ProcesscatsController {
	var $autoRender = false;
}

class ProcesscatsControllerTest extends CakeTestCase {
	var $Processcats = null;

	function startTest() {
		$this->Processcats = new TestProcesscats();
		$this->Processcats->constructClasses();
	}

	function testProcesscatsControllerInstance() {
		$this->assertTrue(is_a($this->Processcats, 'ProcesscatsController'));
	}

	function endTest() {
		unset($this->Processcats);
	}
}
?>