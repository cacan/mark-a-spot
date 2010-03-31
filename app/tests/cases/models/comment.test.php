<?php 
/* SVN FILE: $Id$ */
/* Comment Test cases generated on: 2009-09-19 06:06:46 : 1253333206*/
App::import('Model', 'Comment');

class CommentTestCase extends CakeTestCase {
	var $Comment = null;
	var $fixtures = array('app.comment', 'app.marker');

	function startTest() {
		$this->Comment =& ClassRegistry::init('Comment');
	}

	function testCommentInstance() {
		$this->assertTrue(is_a($this->Comment, 'Comment'));
	}

	function testCommentFind() {
		$this->Comment->recursive = -1;
		$results = $this->Comment->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Comment' => array(
			'id'  => 1,
			'marker_id'  => 1,
			'title'  => 'Lorem ipsum dolor sit amet',
			'comment'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'status'  => 1,
			'created'  => '2009-09-19 06:06:46',
			'modified'  => '2009-09-19 06:06:46'
		));
		$this->assertEqual($results, $expected);
	}
}
?>