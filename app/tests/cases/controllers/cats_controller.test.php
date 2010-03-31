<?php 
/* SVN FILE: $Id$ */
/* CatsController Test cases generated on: 2009-10-07 21:11:53 : 1254942713*/
App::import('Controller', 'Cats');

class TestCats extends CatsController {
	var $autoRender = false;
}

class CatsControllerTest extends CakeTestCase {
	var $Cats = null;

	function startTest() {
		$this->Cats = new TestCats();
		$this->Cats->constructClasses();
	}

	function testCatsControllerInstance() {
		$this->assertTrue(is_a($this->Cats, 'CatsController'));
	}

	function endTest() {
		unset($this->Cats);
	}
}
?>