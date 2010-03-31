<?php
class User extends AppModel {
    var $displayField = 'email_address';
    var $name = 'User';

    var $hasAndBelongsToMany = array(
            'Group' => array('className' => 'Group',
                        'joinTable' => 'groups_users',
                        'foreignKey' => 'user_id',
                        'associationForeignKey' => 'group_id',
                        'unique' => true
            )
    );
    
    var $hasMany = array(
		'Marker' => array(
			'className' => 'Marker',
			'foreignKey' => 'user_id',
			'dependent' => true,
		),
		/*
'Attachment' => array(
            'className' => 'Media.Attachment',
            'foreignKey' => 'foreign_key',
            'conditions' => array('Attachment.model' => 'Marker'),
            'dependent' => true
        )
*/
	);

    
    
    var $validate=array(
    	'email_address' => array(
    		'notempty' => array( 
				'rule' => 'email',
	    		'required' => true,
	    		'allowEmpty' => false,
	    		'message' => 'We need a valid e-mail address'
	    		),
			'checkUnique' => array(
				'rule' => array('checkUnique', 'email_address'),
				'message' => 'This e-mail adress is already registered'
				)
			),
		'password'=>array(
			'notempty' => array(
				'rule' => array('minLength',6),
				'required' => true,
				'allowEmpty' => false,
				'message' => 'We need a password with a minimum of 6 chars'
			 )
			),
		'passwd'=>array(
		     'notempty' =>array(
				'rule' => 'checkPasswords',
				'rule' => array('minLength',6),
				'required' => true,
				'allowEmpty' => false,
				'message' => 'The passwords are not same'
				)			  
			),
		'fon' => array(  
			'required' => false,
			'allowEmpty' => true,   
			'rule' => array('custom', '/^[0-9]{4,25}$/i'), 
			'message' => 'Only numbers allowed here (min. 4 chars)'   
			 ),
		'nickname' => array (
			'notempty' => array( 
				'rule' => array('between', 3, 10),
	    		'required' => true,
	    		'allowEmpty' => false,
	    		'message' => 'Please choose a nickname (minimum 3, maximum 10 chars)'
	    	),
			'checkUnique' => array(
				'rule' => array('checkUnique', 'nickname'),
				'required' => true,
				'message' => 'This nickname is already in use'
				)
			)
		);

	function checkUnique($data,$fieldName){
		$valid = false;
		if (isset($fieldName)&&($this->hasField($fieldName))){
				$valid = $this->isUnique(array($fieldName=>$data));
		}
		return $valid;
	}
	
	function checkPasswords($data) {
		if ($data['password'] == $this->data['User']['passwdhashed']) 
			return true;
		return false;
	}

}
?>