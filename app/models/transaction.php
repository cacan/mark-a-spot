<?php
class Transaction extends AppModel {

	var $name = 'Transaction';
	var $validate = array(
//
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Marker' => array(
			'className' => 'Marker',
			'foreignKey' => 'marker_id',
			'conditions' => '',
			'fields' => '',
			'order' => 'Transaction.created DESC' // for Logfile Descendent
		)
	);

}
?>