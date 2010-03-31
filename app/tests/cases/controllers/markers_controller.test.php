<?php 
/* SVN FILE: $Id$ */
/* MarkersController Test cases generated on: 2009-09-19 06:13:45 : 1253333625*/
App::import('Controller', 'Markers');

class TestMarkers extends MarkersController {
	var $autoRender = false;
}

class MarkersControllerTest extends CakeTestCase {
	var $Markers = null;

	function startTest() {
		$this->Markers = new TestMarkers();
		$this->Markers->constructClasses();
	}

	function testMarkersControllerInstance() {
		$this->assertTrue(is_a($this->Markers, 'MarkersController'));
	}

	function endTest() {
		unset($this->Markers);
	}
}
?>