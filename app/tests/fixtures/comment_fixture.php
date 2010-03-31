<?php 
/* SVN FILE: $Id$ */
/* Comment Fixture generated on: 2009-09-19 06:06:46 : 1253333206*/

class CommentFixture extends CakeTestFixture {
	var $name = 'Comment';
	var $table = 'comments';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'marker_id' => array('type'=>'integer', 'null' => false),
		'title' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 50),
		'comment' => array('type'=>'text', 'null' => true, 'default' => NULL),
		'status' => array('type'=>'boolean', 'null' => false),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'marker_id'  => 1,
		'title'  => 'Lorem ipsum dolor sit amet',
		'comment'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'status'  => 1,
		'created'  => '2009-09-19 06:06:46',
		'modified'  => '2009-09-19 06:06:46'
	));
}
?>