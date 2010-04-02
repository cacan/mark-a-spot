<?php
/**
 * Mark-a-Spot Marker Controller
 *
 * Everything about controlling markers
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

class MarkersController extends AppController {

	var $name = 'Markers';
    var $helpers = array('Form', 
    				'Rss', 
    				'Html', 
    				'Javascript', 
    				'Time', 
    				'Text', 
    				'xml', 
    				'Datum', 
    				'JsValidate.Validation', 
    				//'Recaptcha',
    				'Media.Medium' => array('versions' => array('s', 'xl'))
    				);
	var $components = array(
						'RequestHandler', 
						'Geocoder', 
						'Cookie', 
						'Notification', 
						//'Recaptcha'
						);
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array(
							'startup', 
							'index', 
							'ratesum', 
							'json', 
							'view', 
							'ratings', 
							'maprate', 
							'comments', 
							'ajaxlist', 
							'ajaxmylist', 
							'districts', 
							'rss', 
							'catlist'
							)
						);
							
		if ($this->action == "startup" && $this->params['pass']) {
			$this->Session->write('addAdress.street', $this->params['pass'][1]);
			$this->Session->write('addAdress.zip', $this->params['pass'][2]);
		}
		
		
		$uGroupAdmin 	= Configure::read('userGroup.admins');
		$uGroupSysAdmin = Configure::read('userGroup.sysadmins');
		$uGroupUser 	= Configure::read('userGroup.users');
		
		
		// Create a cookie for Google Maps tab
		// to make markers draggable
		
		if ($this->Auth->user('id')) {
			//$conditions = array("user_id" => $this->Auth->user('id'));
			$userGroup = $this->Groups_user->field('group_id',array('user_id' => $this->Auth->user('id')), 'user_id');
			$this->Session->write('userGroup', $userGroup);
			$this->set("userGroup", $this->Session->read('userGroup'));
			
			if ($userGroup == $uGroupAdmin || 
				$userGroup == $uGroupSysAdmin) {
					$this->Cookie->write('admin', 1, true, '+2 weeks');
			}
		} else {
			$this->Cookie->del('admin');
			$this->set("userGroup", "");
		}

		// Can Access checks if marker belongs to user
		if (in_array($this->action, array('delete', 'edit')) && isset($this->params['pass'][0])) {

	      if (!$this->Marker->canAccess($this->Auth->user('id'), $this->params['pass'][0]) 
	      	&& $userGroup[0]['Groups_user']['group_id'] != $uGroupSysAdmin 
	      	&& $userGroup[0]['Groups_user']['group_id'] != $uGroupAdmin) {
				$this->Session->setFlash(__('You are not allowed here!',true), 'default',array('class' => 'flash_error'));
				$this->redirect(array('action' => 'index'));
			}
		}
	}


 	/**
	 * Main application
	 * Markers are called separately by JSON, we only need category and process status
	 *
	 */	 
	function app() {
		$this->layout = 'default_marker'; 
		$this->set('title', __('Map and List View',true));
		$this->Marker->Cat->recursive = -1;
		$cats = $this->Marker->Cat->find('all');
		$this->Marker->Processcat->recursive = -1;
		$processcats = $this->Marker->Processcat->find('all');
		$this->District->recursive = -1;
		$this->set('cats',$cats);
		$this->set('processcats',$processcats);
		$this->set('districts', $this->District->find('all'));
		$this->set("CSS", "styles"); 
		$this->set('markers', $this->paginate());
	}
	
	
	/**
	 * Splash page
	 *
	 */	
	function index() {
		$this->layout = 'default_splash'; 
		$this->Marker->unbindModel(array('hasMany' => array('Comment')));
		$this->set('title', __('Welcome to mas-city.com/markaspot',true));
		$this->set("CSS", "styles"); 
		$this->set('markers', 
			$this->Marker->publish($this->Marker->find('all', 
				array('fields' => 
					array('Marker.id',
						'Marker.subject', 
						'Marker.cat_id', 
						'Marker.processcat_id', 
						'Marker.lat', 
						'Marker.lon', 
						'Marker.rating', 
						'Marker.votes', 
						'Marker.modified' , 
						'User.nickname', 
						'Cat.Name', 
						'Processcat.Name', 
						'Processcat.id',
						'Cat.Hex', 
						'Processcat.Hex'),
					'order' => array('Marker.modified DESC'),//string or array defining order
							'limit' => 3 //int
					)
				)
			));			
	}


	/**
	 * Personal List View
	 *
	 *
	 */
	function mylist() {
		$this->layout = 'default_page';
		$this->set('title', __('Markers in a list',true));

		if ($this->params['named']['processcat']) {
			$condition = array('Marker.processcat_id' => $this->params['named']['processcat']);
			// Set ProcessCat for heading
			$this->Marker->Processcat->recursive = -1;
			$this->set('processcat', $this->Marker->Processcat->read('Name', $this->params['named']['processcat']));
		
		} elseif ($this->params['named']['cat']) {
			$condition = array('Marker.cat_id' => $this->params['named']['cat']);
			// Set Cat for heading
			$this->Marker->Cat->recursive = -1;
			$this->set('cat', $this->Marker->Cat->read('Name', $this->params['named']['cat']));	
		}
		
			
		//$this->Marker->Cat->recursive = -1;
		$cats = $this->Marker->Cat->find('all');
		$this->set('cats',$cats);
		$processcats = $this->Marker->Processcat->find('all');
		$this->set('processcats',$processcats);
		$this->set('markers', $this->paginate(null, $condition));
	}
	
	/**
	 * Accessible List View
	 *
	 *
	 */
	function liste() {
		$this->layout = 'default_page';
		$this->set('title', __('Markers in a list',true));

		/**
		 * Create Header h2
		 *
		 */	
		if ($this->params['named']['processcat']) {
			$condition = array('Marker.processcat_id' => $this->params['named']['processcat']);
			$this->Marker->Processcat->recursive = -1;
			$this->set('h2Processcat', $this->Marker->Processcat->read('Name', $this->params['named']['processcat']));
		
		} elseif ($this->params['named']['cat']) {
			$condition = array('Marker.cat_id' => $this->params['named']['cat']);
			$this->Marker->Cat->recursive = -1;
			$this->set('h2Cat', $this->Marker->Cat->read('Name', $this->params['named']['cat']));	
		}
		
			
		$this->Marker->Cat->recursive = -1;
		$cats = $this->Marker->Cat->find('all');
		$this->set('cats',$cats);
		
		$this->Marker->Processcat->recursive = -1;
		$processcats = $this->Marker->Processcat->find('all');
		$this->set('processcats',$processcats);

		$this->Marker->recursive = 0;
		$this->set('markers', $this->Marker->publish($this->paginate(null, $condition)));
	}
	
	/**
	 * Paginated list view
	 *
	 *
	 */
	function ajaxList() {
		$condition = '';
		if ($this->params['named']) {
			$condition = array('Marker.processcat_id' => $this->params['named']['processcat']);
			// Set ProcessCat for heading
			$this->Marker->Processcat->recursive = -1;
			$this->set('processcat', $this->Marker->Processcat->read('Name', $this->params['named']['processcat']));
		
		} elseif ($this->params['named']) {
			$condition = array('Marker.cat_id' => $this->params['named']['cat']);
			// Set Cat for heading
			$this->Marker->Cat->recursive = -1;
			$this->set('cat', $this->Marker->Cat->read('Name', $this->params['named']['cat']));	
		}
		
		if ($this->params['named']){
			$this->set('getIdCat', $this->params['named']['cat']);
		}
		if ($this->params['named']) {
			$this->set('getIdProcesscat', $this->params['named']['processcat']);	
		}	
		$this->Marker->Cat->recursive = -1;
		$cats = $this->Marker->Cat->find('all');
		$this->set('cats', $cats);
		$this->Marker->Processcat->recursive = -1;
		$processcats = $this->Marker->Processcat->find('all');
		$this->set('processcats',$processcats);
		$this->set('markers', $this->Marker->publish($this->paginate(null, $condition)));	
		
	}

	/**
	 * Paginates list view / user 
	 *
	 */
	function ajaxMyList() {
		//exit;
		$condition = '';
		if ($this->params['named']) {
			$condition = array('Marker.processcat_id' => $this->params['named']['processcat']);
			// Set ProcessCat for heading
			$this->Marker->Processcat->recursive = -1;
			$this->set('processcat', $this->Marker->Processcat->read('Name', $this->params['named']['processcat']));
		
		} elseif ($this->params['named']) {
			$condition = array('Marker.cat_id' => $this->params['named']['cat']);
			// Set Cat for heading
			$this->Marker->Cat->recursive = -1;
			$this->set('cat', $this->Marker->Cat->read('Name', $this->params['named']['cat']));	
		}
		
		if ($this->params['named']){
			$this->set('getIdCat', $this->params['named']['cat']);
		}
		if ($this->params['named']) {
			$this->set('getIdProcesscat', $this->params['named']['processcat']);	
		}	
		$this->Marker->Cat->recursive = -1;
		$cats = $this->Marker->Cat->find('all');
		$this->set('cats', $cats);
		$this->Marker->Processcat->recursive = -1;
		$processcats = $this->Marker->Processcat->find('all');
		$this->set('processcats',$processcats);
		$this->set('markers', $this->Marker->publish($this->paginate(null, array('Marker.user_id'=>$this->Auth->user('id')))));
		$this -> render('ajaxlist');

	}



	/**
	 * Add Markers the normal way (pre-registration is needed)
	 *
	 */
	function add() {
		//pr($this->data);

		$this->layout = 'default_page'; 
		$this->set('title', __('Add Marker',true));
	
		if (!empty($this->data)) {
	       	$address  = $this->data['Marker']['street'];
			$address .= ' '.$this->data['Marker']['zip'];
			$address .= ' '.Configure::read('Gov.town');
			$latlng = $this->Geocoder->getLatLng($address);
			$this->data['Marker']['lat'] = $latlng['lat'];
			$this->data['Marker']['lon'] = $latlng['lng'];
			
			
			$this->data['Marker']['user_id'] = $this->Auth->user('id');
			$this->data['Marker']['processcat_id'] = 1;
 			$this->Marker->create();
			
			if ($this->Marker->saveAll($this->data)) {
				$this->Session->setFlash(sprintf(__('The Marker ID# %s has been saved. Please check your e-mail.',true),$this->Marker->id), 
					'default',array('class' => 'flash_success'));
				$this->Marker->Transaction->saveField('marker_id', $this->Marker->id);
				$this->Marker->Transaction->saveField('name', __('Marker added',true));
				$this->Marker->saveField('transaction_id', $this->Marker->Transaction->id);				

				
				// send confirmation Mail
				$recipient = $this->Auth->user('email_address');
				$this->Notification->sendMessage("markeradd",$this->Marker->id,$recipient);

				$this->redirect(array('controller'  => 'markers', 'action' => 'app'));
			} else {
				$this->Session->setFlash(__('This marker could not be saved.',true), 
										'default', 
										array('class' => 'flash_error'));
			}
		}
		
		$this->data['Marker']['street'] = $this->Session->read('addAdress.street');
		$this->data['Marker']['zip'] = $this->Session->read('addAdress.zip');

		$cats = $this->Marker->Cat->find('list');
		$this->set(compact('cats'));
		$districts = $this->Marker->District->find('list');
		$this->set(compact('districts'));
		$processcats = $this->Marker->Processcat->find('list');
		$this->set(compact('processcats'));
	} 



	/**
	 * Add Markers directly (included-registration)
	 *
	 */
	function startup() {
	
		// check for login to redirect to add
		 
		if ($this->Auth->user('id')) {
			$this->redirect(array('controller'  => 'markers', 'action' => 'add'));
		}
 
		 
		$this->layout = 'default_page'; 
		$this->set('title', 'Hello, please add a marker');
	
		if (!empty($this->data)) {
			
			if (isset($this->data['User']['passwd'])) {
						$this->data['User']['passwdhashed'] = $this->Auth->password($this->data['User']['passwd']);
				}
			

			// set User non-active and Group for Users
			 
			$this->data['User']['active'] = 0;			
			$this->data['Group']['id'] = '4abe2bc9-2554-427f-bb9e-e88e510ab7ac';
			$this->User->create();
		
					
			//Save all UserData
			$this->User->create();
			
			if ($this->User->save($this->data)) {
		        $address  = 	$this->data['Marker']['street'];
				$address .= ' '.$this->data['Marker']['zip'];
				$address .= ' '.Configure::read('Gov.town');

				$latlng = $this->Geocoder->getLatLng($address);
				
				//all marker's stuff
				
				$this->data['Marker']['city'] = Configure::read('Gov.town');
				$this->data['Marker']['lat'] = $latlng['lat'];
				$this->data['Marker']['lon'] = $latlng['lng'];
	
							
				$this->data['Marker']['user_id'] = $this->User->id;
				$this->data['Marker']['processcat_id'] = 1;			
	
				
				// now unbind user-relation in order to save
				// $this-data with attachment
		        $this->Marker->unbindModel(array('belongsTo' => array('User')));

				if ($this->Marker->saveAll($this->data)) {
					//$this->Attachement->save($this->data['Attachment']);
					$this->Session->setFlash(sprintf(__('The Marker ID# %s has been saved. Please check your e-mail.',true),
						$this->Marker->id), 'default',array('class' => 'flash_success'));
					$this->Marker->Transaction->saveField('marker_id', $this->Marker->id);
					$this->Marker->Transaction->saveField('name', __('Marker added',true));
					$this->Marker->saveField('transaction_id', $this->Marker->Transaction->id);				
					
					// send confirmation Mail with confirmation Link
					// plus preview_link
				    $recipient = $this->data['User']['email_address'];		
					$this->Notification->sendMessage("welcome", $this->Marker->id, $recipient);

	
					$this->redirect(array('controller'  => 'markers', 'action' => 'app'));
				} else {
					$this->Session->setFlash(__('This marker could not be saved.',true), 
													'default',
													array('class' => 'flash_error'));
				}
			$this->data['User']['passwd'] =null;
			$this->data['User']['password'] =null;
	
			}
	
		}
		
		$cats = $this->Marker->Cat->find('list');
		$this->set(compact('cats'));
		$districts = $this->Marker->District->find('list');
		$this->set(compact('districts'));
		$processcats = $this->Marker->Processcat->find('list');
		$this->set(compact('processcats'));
		$this->data['User']['passwd'] = null;
		$this->data['User']['password'] = null;
		$this->data['Marker']['street'] = $this->Session->read('addAdress.street');
		$this->data['Marker']['zip'] = $this->Session->read('addAdress.zip');

	}


	/**
	 * details
	 *
	 */	
	function view($id = null) {
		$this->layout = 'default_page';
		$this->set('title', 'Hinweis im Detail');
		$data = $this->Marker->read(null, $id);
		$this->set('marker', $data);
 		
 		if (!$id || !$data) {
			$this->Session->setFlash(__('This marker does not exist.',true), 
											'default',
											array('class' => 'flash_error'));
			$this->redirect(array('controller'  => 'markers', 'action' => 'app'));
		}
		//$marker = $this->Marker->read(); 
		$undo_rev = $this->Marker->Previous(); 
		$history = $this->Marker->revisions(); 
		$users = $this->Marker->User->find('list'); 
		$this->set(compact('undo_rev', 'history', 'users')); 
	}
	
	
	/**
	 * preview marker after startup
	 *
	 */
	function preview($id = null) {
		$this->layout = 'default_page';
		$this->set('title', 'Preview marker');
		$data = $this->Marker->read(null, $id);
		$this->set('marker', $data);
 		
 		if (!$id || !$data) {
			$this->Session->setFlash(__('This marker does not exist.',true), 
											'default',
											array('class' => 'flash_error'));
			$this->redirect(array('controller'  => 'markers', 'action' => 'app'));
		}
		//$marker = $this->Marker->read(); 
		$undo_rev = $this->Marker->Previous(); 
		$history = $this->Marker->revisions(); 
		$users = $this->Marker->User->find('list'); 
		$this->set(compact('undo_rev', 'history', 'users')); 
	}	
	
	
	/**
	 * administrate markers as admin
	 *
	 */	
	function admin($id = null, $version_id = null) {
		$this->set('title', 'Edit marker');
		$this->layout = 'default_page';
		 
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('This marker does not exist.',true), 'default',array('class' => 'flash_error'));
			$this->redirect(array('action' => 'index'));
		}

		if (!empty($this->data)) {
			$address  = $this->data['Marker']['street'];
			$address .= ' '.$this->data['Marker']['zip'];
			$address .= ' '.Configure::read('Gov.town');
			$latlng = $this->Geocoder->getLatLng($address);
			$this->data['Marker']['lat'] = $latlng['lat'];
			$this->data['Marker']['lon'] = $latlng['lng'];
			
			$this->data['Comment'][0]['status'] = 1;
			$this->data['Comment'][0]['group_id']	= Configure::read('userGroup.admins');
			$this->data['Comment'][0]['user_id']	= $this->Auth->user('id');
			$this->data['Comment'][0]['comment']	= $this->data['Marker']['admincomment'];

			if ($this->Marker->saveAll($this->data)) {
				$id = $this->Marker->id;
				//$this->Session->setFlash(__('Der Hinweis wurde gespeichert!',true), 'default',array('class', 'flash_success'));
				
				$this->Marker->Transaction->saveField('marker_id', $id);
				$this->Marker->Transaction->saveField('name', __('Marker edited by authorities',true));
				
				// send confirmation Mail
			
				// read User data  

 				$client = $this->Marker->read(null, $id);
				if ($this->data['Marker']['notify'] == 1) {


				    $recipient = $client['User']['email_address'];
					$this->Notification->sendMessage("update", $this->Marker->id, $recipient);

					$this->Session->setFlash(sprintf(__('The Marker ID# %s has been saved. 
															The user will be notified by e-mail.',true),
															$this->Marker->id), 
															'default',
															array('class' => 'flash_success'));
				
					$this->redirect($this->referer(null, true)); 
				} else {
					$this->Session->setFlash(sprintf(__('The Marker ID# %s has been saved.',true),$this->Marker->id), 
															'default', 
															array('class' => 'flash_success'));
					$this->redirect($this->referer(null, true)); 				
				}

			} else {
				$this->Session->setFlash(__('This marker could not be saved.',true), 
												'default',
												array('class', 'flash_error'));
			}
		}
		$cats = $this->Marker->Cat->find('list');
		$this->set(compact('cats'));
		$districts = $this->Marker->District->find('list');
		$this->set(compact('districts'));
		$processcats = $this->Marker->Processcat->find('list');
		$this->set(compact('processcats'));

		if (empty($this->data)) {
			//$this->data = $this->Marker->read(null, $id);
		
			if (is_numeric($version_id)) { 
				$this->data = $this->Marker->shadow('first',array('conditions' => array('version_id' => $version_id))); 
			} else { 
				$this->data = $this->Marker->read(null,$id); 
			} 
		}

		$this->set('marker', $this->Marker->read(null, $id));
		$undo_rev = $this->Marker->Previous(); 
		$history = $this->Marker->revisions(); 
		$users = $this->Marker->User->find('list'); 
		$this->set(compact('undo_rev', 'history', 'users')); 
		
		
		
		// Configure::write('debug', 3);
		// Comment-Administration
		// overwrite condition status = 1
		 
		$this->Marker->Comment->recursive = -1;
		$this->set('comments', $this->Marker->Comment->find('all', 
							array('conditions' => 
								array('marker_id' => $id), 'status => 0')));

		
		if (empty($this->data)) {
			$this->data = $this->Marker->read(null, $id);


		}
	}
	
	
	/**
	 * edit markers as user
	 *
	 */	
	function edit($id = null,$version_id = null) {
		$this->Marker->id = $id; //important for read,shadow and revisions call bellow 
		$this->set('title', 'Edit marker');
		$this->layout = 'default_page'; 
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('This marker does not exist.',true), 
											'default',
											array('class' => 'flash_error'));
			$this->redirect(array('action' => 'index'));
		}

		if (!empty($this->data)) {
			$address  = $this->data['Marker']['street'];
			$address .= ' '.$this->data['Marker']['zip'];
			$address .= ' '.Configure::read('Gov.town');
			$latlng = $this->Geocoder->getLatLng($address);
			$this->data['Marker']['lat'] = $latlng['lat'];
			$this->data['Marker']['lon'] = $latlng['lng'];

			if ($this->Marker->saveAll($this->data)) {
				$this->Session->setFlash(__('This marker has been saved.',true), 
												'default',
												array('class' => 'flash_success'));
				$this->redirect($this->referer(null, true)); 

			} else {
				$this->Session->setFlash(__('This marker could not be saved.',true), 
												'default',
												array('class' => 'flash_error'));
			}
		}
		$cats = $this->Marker->Cat->find('list');
		$this->set(compact('cats'));
		$districts = $this->Marker->District->find('list');
		$this->set(compact('districts'));
		$processcats = $this->Marker->Processcat->find('list');
		$this->set(compact('processcats'));

		if (empty($this->data)) {
			//$this->data = $this->Marker->read(null, $id);
		
			if (is_numeric($version_id)) { 
			$this->data = $this->Marker->shadow('first',array('conditions' => array('version_id' => $version_id))); 
			} else { 
			$this->data = $this->Marker->read(null,$id); 
			} 
		}
		$this->set('marker', $this->Marker->read(null, $id));
		$undo_rev = $this->Marker->Previous(); 
		$history = $this->Marker->revisions(); 
		$users = $this->Marker->User->find('list'); 
		$this->set(compact('undo_rev', 'history', 'users')); 

		if (empty($this->data)) {
			$this->data = $this->Marker->read(null, $id);

		}
	}
	
	/**
	 * update position as admin
	 *
	 */	
	function geoSave($id = null) {
		$this->layout = 'ajax'; 
		
		if ($this->params['pass'][0] != "undefined") {
			$id=$this->params['pass'][0];
		} else {
			exit;
		}
	$address = explode(", ", $this->params['pass'][3]);
	$address = array_reverse($address); 
	
	$splitCity=explode(" ", $address[1]);
		
		$this->data['Marker']['zip'] 	= $splitCity[0];
		$this->data['Marker']['city'] = Configure::read('Gov.town');

		$fields = array($this->data['Marker']['lat'],$this->data['Marker']['lon']);
		$this->Marker->id = $id;

		if (!$id && empty($this->data)) {
					$this->Session->setFlash(__('This marker does not exist.',true), 
													'default',
													array('class' => 'flash_error'));
					$this->redirect(array('action' => 'index'));
				}
				
		if (!empty($this->data)) {
		
			if ($this->RequestHandler->isAjax()) {
		
				if ($this->Marker->saveField('lat', $this->params['pass'][1], $validate = false))
					$this->set(flash_success_1, 'lat ok');
				
				if ($this->Marker->saveField('lon', $this->params['pass'][2], $validate = false))
					$this->set(flash_success_2, 'lon ok');
				
				if ($this->Marker->saveField('zip', $splitCity[1], $validate = false))
					$this->set(flash_success_3, 'PLZ ok');
				
				if ($this->Marker->saveField('city', $splitCity[2], $validate = false))
					$this->set(flash_success_4, 'Stadt ok');
				
				if ($this->Marker->saveField('street', $address[2], $validate = false)) {
					$this->set(flash_success_5, 'Straße ok');
					
				}			
				$this->Marker->Transaction->saveField('marker_id', $id);
				$this->Marker->Transaction->saveField('name', __('Marker&rsquo;s position fixed or moved',true));
				$this->Marker->saveField('transaction_id', $this->Marker->Transaction->id);				


			}
		}
	}
	
	
	/**
	 * get id for star-rating
	 *
	 */		
	function mapRate($id = null) {
		Configure::write('debug', 0);
		$this->layout = 'ajax'; 
		$this->set('id',$id=$this->params['url']['id']);
	}
	
	/**
	 * undo last change for users
	 *
	 */	
	function undo($id = null) {
		$this->Marker->id = $id; 
		$this->Marker->undo(); 
		$this->redirect($this->referer());

		//$this->redirect(array('action' => 'view',$id)); 
	}


	/**
	 * versioning for admins
	 *
	 */	
	function makeCurrent($id, $version_id) { 
		$this->Marker->id = $id; 
		$this->Marker->revertTo($version_id); 
		$this->redirect(array('action' => 'view',$id)); 
	} 
	
	
	/**
	 * delete markers
	 *
	 */		
	function delete($id) {
		Configure::write('debug', 0);
		$this->layout = 'ajax'; 
		
		if ($this->RequestHandler->isAjax()) {
			if ($this->Marker->delete($id)) {
				echo 'flash_success';
			} else {
				echo 'fail';
			}
			$this->autoRender = false;
			exit();
		} else {
		
			if ($this->Marker->del($id)) {
				$this->Session->setFlash(__('Marker has been deleted', true));
				$this->redirect(array('action' => 'index'));
			}		
		}
	}


	/**
	 * create JSON Object or XML [ change: layout and function xml($id = null) { ]
	 *
	 */
	
	function json($id = null) {   	
		Configure::write('debug', 0);
		$this->layout = 'ajax'; 
		// Um find('all') ohne Kommentare auszuführen: Unbind!
		$this->Marker->unbindModel(array('hasMany' => array('Comment', 'Transaction')));
		
		if (!$this->params['pass']['0'] && $this->params['named']['cat'] == "undefined" 
			&& $this->params['named']['processcat'] == "undefined") {
				$this->set('votes', $this->Rating->find('count'));
				$this->set('markers', $this->Marker->publish($this->Marker->find('all', array(
							'fields' => array(
								'Marker.id', 
								'Marker.subject', 
								'Marker.cat_id', 
								'Marker.processcat_id', 
								'Marker.lat', 
								'Marker.lon', 
								'Marker.rating', 
								'Marker.votes',
								'Cat.Name', 
								'Processcat.id', 
								'Processcat.Name', 
								'Cat.Hex',
								'Processcat.Hex'
							)
						)
					)
				)
				);
		}
		
		 // Markers by Cat
		 elseif (!$this->params['pass']['0'] && $this->params['named']['cat'] != "undefined" 
		 	&& $this->params['named']['processcat'] == "undefined") {
			$this->set('markers', 
				$this->Marker->find('all', array(
							'fields' => array(
								'Marker.id', 				 
								'Marker.subject', 
								'Marker.cat_id',
								'Marker.processcat_id',
								'Marker.lat', 
								'Marker.lon', 
								'Marker.rating', 
								'Marker.votes', 
								'Cat.Name', 
								'Processcat.Name', 
								'Cat.Hex',
								'Processcat.Hex'),
										'conditions' 	=> array(	'Marker.cat_id' => $this->params['named']['cat'],
								)
							)
						)
					); 
		/**
		 *
		 *  Markers by Processcat
		 *
		 */ 
		} elseif (!$this->params['pass']['0'] && $this->params['named']['processcat'] != "undefined" 
			&& $this->params['named']['cat'] == "undefined") {
			$this->set('markers', 
				$this->Marker->find('all', array(
							'fields' => array(
								'Marker.id', 						 
								'Marker.subject', 
								'Marker.cat_id', 
								'Marker.processcat_id', 
								'Marker.lat', 
								'Marker.lon', 
								'Marker.rating', 
								'Marker.votes', 
								'Cat.Name', 
								'Processcat.Name', 
								'Cat.Hex',
								'Processcat.Hex'),
										'conditions' 	=> array( 
												'Marker.processcat_id' => $this->params['named']['processcat'],
												)
							)
						)
				); 
		/**
		 *
		 * Single Call for Single Marker if ID is set
		 *
		 */ 
		} elseif ($this->params['pass']['0']) {

			$this->set('votes', $this->Rating->find('count'));
			$this->set('markers', 
					$this->Marker->find('all', array(
							'fields' => array(
								'Marker.id', 						 
								'Marker.subject', 
								'Marker.cat_id', 
								'Marker.processcat_id', 
								'Marker.lat', 
								'Marker.lon', 
								'Marker.rating', 
								'Marker.votes', 
								'Cat.Name', 
								'Processcat.Name', 
								'Cat.Hex',
								'Processcat.Hex'),
										'conditions' 	=> array( 
												'Marker.id' => $this->params['pass']['0']
												)
							)
						)
				); 
		}
	}	
	
	function ratesum() {
		$this->layout = 'ajax'; 
		$this->set('votes', $this->Rating->find('count'));	
	}




  	function rss() { 
		Configure::write('debug', 0);
		//$this->Marker->unbindModel(array('hasMany' => array('Comment')));
       	$this->set('markers', 
       			$this->Marker->find('all', 
       				array(
						'order' => array('Marker.modified DESC'), 
						'limit' => 15 //int
						)
					)
				);	
		$this->set('channel', 
				array(
					'title' => Configure::read('Site.domain'),
					'description' => __('Managing Concerns of Public Space', true),
					'link' => '/rss',
					'url' => '/rss',
					'language' => 'de'
				)
			);
		$this->set(compact('markers'));
		$this->RequestHandler->respondAs('rss');
		$this->viewPath .= '/rss';
		$this->layoutPath = 'rss';
	} 
}
?>