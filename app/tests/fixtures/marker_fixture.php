<?php 
/* SVN FILE: $Id$ */
/* Marker Fixture generated on: 2009-10-07 21:03:28 : 1254942208*/

class MarkerFixture extends CakeTestFixture {
	var $name = 'Marker';
	var $table = 'markers';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'gov_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'user_id' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36),
		'processcat_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'district' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'location' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 256),
		'descr' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'photo' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 256),
		'photo_desc' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'youtube' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 256),
		'youtube_desc' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 256),
		'cat_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 4),
		'lat' => array('type'=>'float', 'null' => false, 'default' => '0.000000', 'length' => '10,6'),
		'lon' => array('type'=>'float', 'null' => false, 'default' => '0.000000', 'length' => '10,6'),
		'status' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 2),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'rating' => array('type'=>'float', 'null' => true, 'default' => '0.0', 'length' => '3,1'),
		'votes' => array('type'=>'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'gov_id'  => 1,
		'user_id'  => 'Lorem ipsum dolor sit amet',
		'processcat_id'  => 1,
		'district'  => 1,
		'location'  => 'Lorem ipsum dolor sit amet',
		'descr'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
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
}
?>