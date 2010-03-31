<?php 
/* SVN FILE: $Id$ */
/* Marker Test cases generated on: 2009-10-07 21:03:36 : 1254942216*/
App::import('Model', 'Marker');

class MarkerTestCase extends CakeTestCase {
	var $Marker = null;
	var $fixtures = array('app.marker', 'app.user', 'app.processcat', 'app.cat', 'app.comment', 'app.image', 'app.comment', 'app.image');

	function startTest() {
		$this->Marker =& ClassRegistry::init('Marker');
	}

	function testMarkerInstance() {
		$this->assertTrue(is_a($this->Marker, 'Marker'));
	}

	function testMarkerFind() {
		$this->Marker->recursive = -1;
		$results = $this->Marker->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Marker' => array(
			'id'  => 1,
			'gov_id'  => 1,
			'user_id'  => 'Lorem ipsum dolor sit amet',
			'processcat_id'  => 1,
			'district'  => 1,
			'location'  => 'Lorem ipsum dolor sit amet',
			'hint'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'photo'  => 'Lorem ipsum dolor sit amet',
			'photo_desc'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'youtube'  => 'Lorem ipsum dolor sit amet',
			'youtube_desc'  => 'Lorem ipsum dolor sit amet',
			'cat_id'  => 1,
			'lat'  => 1,
			'lon'  => 1,
			'status'  => 1,
			'created'  => '2009-10-07 21:03:28',
			'modified'  => '2009-10-07 21:03:28',
			'rating'  => '2009-10-07 21:03:28',
			'votes'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>