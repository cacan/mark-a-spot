<?php
class Cat extends AppModel {

	var $name = 'Cat';
	var $validate = array(
		'hex' => array('notempty')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Marker' => array(
			'className' => 'Marker',
			'foreignKey' => 'cat_id'
		)
	);

}
?>