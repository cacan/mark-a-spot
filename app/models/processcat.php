<?php
class Processcat extends AppModel {

	var $name = 'Processcat';
	var $validate = array(
		'hex' => array('notempty')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Marker' => array(
			'className' => 'Marker',
			'foreignKey' => 'processcat_id'
		)
	);

}
?>