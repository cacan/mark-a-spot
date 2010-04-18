<?php
/**
 * Mark-a-Spot Marker Model
 *
 * 
 *
 * Copyright (c) 2010 Holger Kreis
 * http://www.mark-a-spot.org
 *
 *
 * PHP version 5
 * CakePHP version 1.2
 *
 * @copyright  2010 Holger Kreis <holger@markaspot.org>
 * @license    http://www.gnu.org/licenses/agpl-3.0.txt GNU Affero General Public License
 * @link       http://mark-a-spot.org/
 * @version    0.98
 */
 
 
class Marker extends AppModel {
	var $name = 'Marker';
	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Cat' => array(
			'className' => 'Cat',
			'foreignKey' => 'cat_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Processcat' => array(
			'className' => 'Processcat',
			'foreignKey' => 'processcat_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'District' => array(
			'className' => 'District',
			'foreignKey' => 'district_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


	var $hasMany = array(
		'Comment' => array(
			'className' => 'Comment',
			'foreignKey' => 'marker_id',
			'dependent' => false,
			'conditions' => array('Comment.status' => '1'),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Attachment' => array(
            'className' => 'Media.Attachment',
            'foreignKey' => 'foreign_key',
            'conditions' => array('Attachment.model' => 'Marker'),
            'dependent' => true
        ),
		'Transaction' => array(
			'className' => 'Transaction',
			'foreignKey' => 'marker_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => 'Transaction.created DESC', // for RSS-Logfile Descendent
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	


	var $actsAs = array(
		'Revision' => array(
				'limit'=>3,
				'ignore'=>array('')),
		'Search.Searchable' => array(
		'fields' => array('subject', 'descr', 'street','zip')
	));

	
	
	
	var $validate = array(
	
		'subject' => array(
			'rule' => array('minLength', '1'), 
			'required' => true, 
			'message'=> 'We need a short subject or title here'
		),
		'descr'	=> array(
			'rule' => array('minLength', '1'), 
			'required' => true, 
			'message' => 'Is there more to say, please describe some details'
		),
		'cat_id'=> array(
			'rule' => array('minLength', '1'),
			'notempty' => true,
			'message' => 'Please choose one of the categories'
		), 
		'street' => array(
			'rule' => array('minLength', '1'),
			'required' => true, 
			'message' => 'Please enter a street or drag the marker in the map'
		)
,
		
		'file' => array(
			'resource'   => array('rule' => 'checkResource'),
			'access'     => array('rule' => 'checkAccess'),
			'location'   => array('rule' => array('checkLocation', array(
				MEDIA_TRANSFER, '/tmp/'
			))),
			'permission' => array('rule' => array('checkPermission', '*')),
			'size'       => array('rule' => array('checkSize', '5M')),
			'pixels'     => array('rule' => array('checkPixels', '1600x1600')),
			'extension'  => array('rule' => array('checkExtension', false, array(
				'jpg', 'jpeg', 'png', 'tif', 'tiff', 'gif', 'pdf', 'tmp'
			))),
			'mimeType'   => array('rule' => array('checkMimeType', false, array(
				'image/jpeg', 'image/png', 'image/tiff', 'image/gif', 'application/pdf'
			))),
			'message' => 'Sorry, we do not like that file'
		),
		'alternative' => array(
			'rule'       => 'checkRepresent',
			'on'         => 'create',
			'required'   => false,
			'allowEmpty' => true,
		)
	);				   
	
	
	/**
	 *
	 *  Publish new markers with full content or with placeholder
	 *
	 */ 
	
	function publish($markers){
		// Filter new unpublished Markers as "New marker #" if neccessary 
		if (!Configure::read('Publish.Markers')) {
			$newMarkers = $markers;
			unset($markers);
			foreach ($newMarkers as $marker):
				if ($marker['Marker']['processcat_id'] == 1) {
					$marker['Marker']['subject'] = __('New Marker ID#',true).' ...'.substr($marker['Marker']['id'],-8);
					$marker['Marker']['descr'] = __('Not yet published',true);
				
				}
				$markers[]= $marker;
			endforeach;
		}

		return $markers;
	}

	function publishRead($marker){
		// Filter new unpublished Markers as "New marker #" if neccessary 
		if (!Configure::read('Publish.Markers')) {
			if ($marker['Marker']['processcat_id'] == 1) {
				$marker['Marker']['subject'] = __('New Marker ID#',true).' ...'.substr($marker['Marker']['id'],-8);
				$marker['Marker']['descr'] = __('Not yet published',true);

			}
		}

		return $marker;
	}		
	
	
	
	/**
	 *
	 *  CanAccess Funktion zum Check der Berechtigung ob user_id des Objektes dem eingeloggten User entspricht.
	 *
	 */ 
	function canAccess($userId = null, $primaryKey = null) {
        if ($this->find('first', array('conditions' => array($this->alias.'.user_id' => $userId, $this->primaryKey => $primaryKey), 'recursive' => -1)))			{
            return true;
        	}
        return false;
		}
	}






?>