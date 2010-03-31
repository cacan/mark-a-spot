<?php
/**
 * Mark-a-Spot AppController
 *
 * Auth
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

class AppController extends Controller {
	var $uses = array('Marker', 'Rating', 'District', 'Groups_user', 'User', 'Comment');		
	var $components = array('Auth', 'Cookie');
	
	function beforeFilter(){
	
		
		$this->set('markerSum', $this->Marker->find('count'));
		$this->set('commentSum', $this->Marker->Comment->find('count'));
		$this->set('ratingSum', $this->Rating->find('count'));
		$this->set('commentLast', $this->Marker->Comment->find('first', array('order' => array('Comment.created DESC'))));
		$this->set('markerLast', $this->Marker->find('first', array('order' => array('Marker.created DESC')))); 
		$this->set('ratingLast', $this->Rating->find('first', array('order' => array('Rating.created DESC')))); 
		//Override default fields used by Auth component
		$this->Auth->fields = array('username'=>'email_address', 'password'=>'password');
		$this->Auth->loginError = __('User or password can not be found. Please try once more!', true);
		$this->Auth->authError  = __('You are not allowed to do this.', true);
		//Set application wide actions which do not require authentication
		$this->Auth->allow(array('startup', 'confirm', 'index', 'searches', 'search', 'suche', 'signup', 'rss', 'maprate', 'app', 'liste', 'useticket', 'newpassword', 'resetpassword', 'login', 'impressum', 'faq', 'Kontakt'));
		//Set the default redirect for users who logout
		$this->Auth->logoutRedirect = '/';
		//Set the default redirect for users who login
		$this->Auth->loginRedirect = '/';
		//Extend auth component to include authorisation via isAuthorized action
		$this->Auth->authorize = 'controller';
		//Restrict access to only users with an active account
		$this->Auth->userScope = array('User.active = 1');
		
		//Read Mark-A-Spot Config app-wide
		Configure::load('mark-a-spot');
		
		$this->_setLanguage();

		
		
		$this->set('googleCenter', Configure::read('Google.Center'));
		$this->set('googleKey', Configure::read('Google.Key'));
		
		$this->set('software', Configure::read('mas'));
		$this->set('uGroupAdmin', Configure::read('userGroup.admins'));
		$this->set('uGroupSysAdmin', Configure::read('userGroup.sysadmins'));
		$this->set('uGroupUser', Configure::read('userGroup.users'));
	}
	
	function _setLanguage() {
		if ($this->Cookie->read('lang')) {
			$this->Session->write('Config.language', $this->Cookie->read('lang'));
			Configure::write('Config.language', $this->Cookie->read('lang'));
			$this->set('lang', $this->Cookie->read('lang'));
		} else if (isset($this->params['language'])) {  
 			$this->Cookie->del('lang');  
			$this->Session->write('Config.language', $this->params['language']);
			//Configure::write('Config.language', $this->params['language']);
			$this->Cookie->write('lang', $this->params['language'], null, '20 days');
			$this->redirect($this->referer(null, true)); 

		} else if(!$this->Cookie->read('lang')){
			//Configure::write('Config.language', Configure::read('Config.language'));
			$this->set('lang', Configure::read('Config.language'));

		}
	}


	function beforeRender(){
		//If we have an authorised user logged then pass over an array of controllers
		//to which they have index action permission
		if($this->Auth->user()){
	
			// User für die Ausgabe ausgeben:    
			$this->set('currentUser', $this->Auth->user());
			
			$controllerList = Configure::listObjects('controller');
			$permittedControllers = array();
			
			foreach($controllerList as $controllerItem){
			
				if($controllerItem <> 'App'){
					if($this->__permitted($controllerItem, 'index')){
						$permittedControllers[] = $controllerItem;
					}
				}
			}
		}
	$this->set(compact('permittedControllers'));
	}
	
	
	/**
	* isAuthorized
	* 
	* Called by Auth component for establishing whether the current authenticated 
	* user has authorization to access the current controller:action
	* 
	* @return true if authorised/false if not authorized
	* @access public
	*/
	function isAuthorized(){
		return $this->__permitted($this->name, $this->action);
	}
	
	/**
	* __permitted
	* 
	* Helper function returns true if the currently authenticated user has permission 
	* to access the controller:action specified by $controllerName:$actionName
	* @return 
	* @param $controllerName Object
	* @param $actionName Object
	*/
	function __permitted($controllerName,$actionName){
		//Ensure checks are all made lower case
		$controllerName = low($controllerName);
		$actionName = low($actionName);
		//If permissions have not been cached to session...
		if(!$this->Session->check('Permissions')){
		//...then build permissions array and cache it
			$permissions = array();
			//everyone gets permission to logout
			$permissions[]='users:logout';
			//Import the User Model so we can build up the permission cache
			App::import('Model', 'User');
			$thisUser = new User;
			//Now bring in the current users full record along with groups
			$thisGroups = $thisUser->find(array('User.id'=>$this->Auth->user('id')));
			$thisGroups = $thisGroups['Group'];
			foreach($thisGroups as $thisGroup){
				$thisPermissions = $thisUser->Group->find(array('Group.id'=>$thisGroup['id']));
				$thisPermissions = $thisPermissions['Permission'];
				foreach($thisPermissions as $thisPermission){
					$permissions[]=$thisPermission['name'];
				}
			}
		//write the permissions array to session
			$this->Session->write('Permissions',$permissions);
		} else {
			//...they have been cached already, so retrieve them
			$permissions = $this->Session->read('Permissions');
		}
		//Now iterate through permissions for a positive match
		foreach($permissions as $permission){
			if($permission == '*'){
				return true;//Super Admin Bypass Found
			}
			if($permission == $controllerName.':*'){
				return true;//Controller Wide Bypass Found
			}
			if($permission == $controllerName.':'.$actionName){
				return true;//Specific permission found
			}
		}
		return false;
	}
	
	/**
	 * Builds the search index for the current model based on existing data.
	 */
	function admin_build_search_index()
	{
		$this->autoRender = false;
		
		$model =& $this->{$this->modelClass};
		
		if(!isset($model->Behaviors->Searchable))
		{
			echo "<pre>Error : the {$model->alias} model is not linked with Searchable Behavior.</pre>";
			exit;
		}
		
		$data = $model->find('all');
		
		foreach($data as $row)
		{
			$model->set($row);
	
			$model->Behaviors->Searchable->Search->saveIndex(
				$model->alias,
				$model->id,
				$model->buildIndex()
			);
		}
		
		echo "<pre>Search index for model {$model->alias} have been built.</pre>";
	}
	
	/**
	 * Delete the search index for the current model.
	 */
	function admin_delete_search_index()
	{
		$this->autoRender = false;
		
		$model =& $this->{$this->modelClass};
		
		if(!isset($model->Behaviors->Searchable))
		{
			echo "<pre>Error : the {$model->alias} model is not linked with Searchable Behavior.</pre>";
			exit;
		}
		
		$model->Behaviors->Searchable->Search->deleteAll(array(
			'model' => $model->alias
		));
		
		echo "<pre>Search index for model {$model->alias} have been deleted.</pre>";
	}
	
	/**
	 * Rebuilds the search index for the current model based on existing data.
	 */
	function admin_rebuild_search_index()
	{
		$this->admin_delete_search_index();
		$this->admin_build_search_index();
	}
}
?>