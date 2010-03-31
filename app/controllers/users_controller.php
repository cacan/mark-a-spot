<?php
/**
 * Mark-a-Spot Users Controller
 *
 * Auth Login, Logout, Lost Passwords
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

class UsersController extends AppController {
	var $name = 'Users';
	var $uses = array('User', 'Groups_user', 'Ticket', 'Marker', 'Comment', 'Rating');
	
	var $helpers = array('Form', 'Html', 'Javascript', 'JsValidate.Validation');
	var $components = array('RequestHandler', 'Email', 'MathCaptcha', 'Cookie', 'Ticketmaster');
	
	var $scaffold;
	
	
	function beforeFilter() {
	parent::beforeFilter();
	$this->Auth->allow(array('startup', 'index', 'ratesum', 'json', 'view', 'ratings', 'maprate',
								'comments', 'ajaxlist', 'ajaxmylist', 'districts', 'rss', 'catlist'
							)
						);
	}
	
	function login() {
		$this->pageTitle = 'Log in';
		$this->layout = 'default_page'; 

			//-- code inside this function will execute only when autoRedirect was set to false (i.e. in a beforeFilter).
		if ($this->Auth->user()) {
			if (!empty($this->data) && $this->data['User']['remember_me']) {
				$cookie = array();
				$cookie['username'] = $this->data['User']['username'];
				$cookie['password'] = $this->data['User']['password'];
				$this->Cookie->write('Auth.User', $cookie, true, '+2 weeks');
				unset($this->data['User']['remember_me']);
			}
			$this->redirect($this->Auth->redirect());
		}
		if (empty($this->data)) {
			$cookie = $this->Cookie->read('Auth.User');
			if (!is_null($cookie)) {
				if ($this->Auth->login($cookie)) {
					//  Clear auth message, just in case we use it.
					$this->Session->del('Message.auth');
					$this->redirect($this->Auth->redirect());
				} else { // Delete invalid Cookie
					$this->Cookie->del('Auth.User');
				}
			}
		}

	}

	function signup() {
		$this->layout = 'default_page'; 
		$this->pageTitle = 'Sign Up';
		if (!empty($this->data)) {
			if ($this->MathCaptcha->validates($this->data['User']['security_code'])) {

				if (isset($this->data['User']['passwd'])) {
						$this->data['User']['passwdhashed'] = $this->Auth->password($this->data['User']['passwd']);
				}
	
				/**
				 * move user into their group
				 *
				 */
			 	$this->data['Group']['id'] ='4abe2bc9-2554-427f-bb9e-e88e510ab7ac';
				$this->data['User']['active'] =1;

				$this->User->create();
				if ($this->User->save($this->data)) {
					$this->Session->setFlash(__('Great, you signed up successfully. Please check your Mail.',true), 'default', array('class' => 'flash_success'));
	
					/**
					 * send confirmation Mail
					 *
					 */
			 
			
					$this->Email->to = $this->data['User']['email_address'];
					$this->Email->subject = Configure::read('e-mail.subject');
					$this->Email->replyTo = 'noreply@'.Configure::read('Site.domain');
					$this->Email->from = Configure::read('Site.admin.name').'<'.Configure::read('Site.e-mail').'>';
					$this->Email->template = 'welcome';
					$this->Email->sendAs = 'text';  
					$this->set('user', $this->data['User']['nickname']);
					$this->set('email', $this->data['User']['email_address']);
		
					$this->set('password', $this->data['User']['passwd']);
					$this->set('sitename',Configure::read('Site.domain'));
					$this->Email->send();
	
					/**
					 * authorize and redirect in 
					 *
					 */
			 	
							
					$this->Auth->login(); 
					$this->redirect(array('controller' => 'markers', 'action'=>'add'));	
			} else {
				$this->Session->setFlash(__('We could&rsquo;nt sign up your account!',true), 
												'default', 
												array('class' => 'flash_error'));
				//$this->set('mathCaptcha', $this->MathCaptcha->generateEquation());

				$this->data['User']['passwd'] =null;
				$this->data['User']['password'] =null;
			}
			} else {
                $this->Session->setFlash(__('Sorry, you are wrong, please recalculate.',true), 
                								'default', 
                								array('class' => 'flash_error'));
				$this->data['User']['passwd'] =null;
				$this->data['User']['password'] =null;
			}
		
			
		
		}
		
		$this->set('mathCaptcha', $this->MathCaptcha->generateEquation());
	}
	
	
	/**
	 *  Confirm User after startup
	 *
	 */
	function confirm($id) { 
			$this->User->id = $id;
			$this->data = $this->User->read(null, $id);
						
			/**
			 * User Bann if banned already
			 *
			 */
			switch ($this->data['User']['active']) {
				case 3:
					exit;
				case 1:
					$this->Session->setFlash(__('You are already confirmed as user.',true), 
													'default',
													array('class' => 'flash_success'));
					$this->redirect(array('controller' => 'markers', 'action'=>'preview', $this->params['pass'][1]));
				break;
			}
			if ($this->data['User']['active'] == 3) {
				exit;
			} else
			 
			if ($this->User->saveField('active', 1)) {
				$this->Session->setFlash(__('You are now confirmed as user.',true),
					'default', array('class' => 'flash_success'));

				$this->Auth->login($this->data);
				
				/**
				 * send confirmation Mail with Username Link
				 * plus preview_link
				 *
				 */
				
				$this->Email->to = $this->data['User']['email_address'];
				$this->Email->subject = __('Your Account Data on ',true).Configure::read('Site.domain');
				$this->Email->replyTo = 'noreply@'.Configure::read('Site.domain');
				$this->Email->from = Configure::read('Site.admin.name').'<'.Configure::read('Site.e-mail').'>';
				$this->Email->template = 'userdata';
				$this->Email->sendAs = 'text';  
				$this->set('user', $this->data['User']['nickname']);
				
				if ($this->data['User']['email_address']) {
					$this->set('email', $this->data['User']['email_address']);
				}

				$this->set('sitename',Configure::read('Site.domain'));
				$this->Email->send();
				$this->redirect(array('controller' => 'markers', 'action'=>'preview', $this->params['pass'][1]));
 
				

			} else {
				$this->Session->setFlash(__('This User does not exist',true), 'default', array('class' => 'flash_error'));			}
			//$this->redirect('/');
	} 

	/**
	 *  user's log out
	 *
	 */
	function logout() {
		$this->Session->del('Permissions');
		if ($this->Session->read('goodbye')) {
				$this->Session->setFlash(__('Your userdata and all markers have been deleted.',true), 
												'default', 
												array('class' => 'flash_success'));
			} else {
			$this->Session->setFlash(__('You logged out successfully',true), 
											'default', 
											array('class' => 'flash_success'));
		}
		$this->redirect($this->Auth->logout());
	}



   	/**
   	 *  Reset Password
   	 *  based on Code from http://edwardawebb.com/programming/php-programming/cakephp/reset-lost-passwords-cakephp
	 *
	 */
	 
	function resetpassword($email=null) {
		$this->pageTitle = 'Forgot password';
		$this->layout = 'default_page'; 
		if (!empty($this->data['User']['email'])) {
			if ($this->MathCaptcha->validates($this->data['User']['security_code'])) {
				$email = $this->data['User']['email'];
				$account=$this->User->findByEmailAddress($email);

				if (!isset($account['User']['email_address'])) {
					$this->Session->setFlash(__('We could not find your e-mail',true), 
													'default', 
													array('class' => 'flash_error'));
					$this->redirect('/');
				}
				
	
				/**
				 * send  Mail with token
				 *
				 */			
				
				
				$hashyToken=md5(date('mdY').rand(2000000,4999999));

		
				$this->Email->to = $email;
				$this->Email->subject = Configure::read('e-mail.resetpw.subject');
				$this->Email->replyTo = 'noreply@'.Configure::read('Site.domain');
				$this->Email->from = Configure::read('Site.admin.name').'<'.Configure::read('Site.e-mail').'>';
				$this->Email->template = 'resetpw';
				$this->Email->sendAs = 'text';  
				$this->set('hashyToken', $hashyToken);
				$this->set('sitename',Configure::read('Site.domain'));
	            $this->Email->send();
		    
				/**
				 * save ticket
				 *
				 */				    
			    
			    
				$data['Ticket']['hash'] =$hashyToken;
				$data['Ticket']['data'] =$email;
				$data['Ticket']['expires'] =$this->Ticketmaster->getExpirationDate();
		
				if ($this->Ticket->save($data)) {
					$this->Session->setFlash(__('Please check your mail to receive more details.',true), 
													'default', 
													array('class' => 'flash_success'));
					$this->redirect('/');
				} else {
				
					$this->Session->setFlash(__('The ticket could not be sent.',true), 
													'default', 
													array('class' => 'flash_flash_error'));
					$this->redirect('/');
	
				}
			}		
		}
		$this->set('mathCaptcha', $this->MathCaptcha->generateEquation());

 
	}

    /**
   	 *  Check ticket hash
   	 *  based on Code from http://edwardawebb.com/programming/php-programming/cakephp/reset-lost-passwords-cakephp
	 *
	 */	
 
	function useticket($hash) {
		//purge all expired tickets
		//built into check
		$results=$this->Ticketmaster->checkTicket($hash);
		if ($results) {
			//now pull up mine IF still present
			$passTicket=$this->User->findByEmailAddress($results['Ticket']['data']);
			$this->Ticketmaster->voidTicket($hash);
			$this->Session->write('tokenreset',$passTicket['User']['id']);
			//$this->Session->setFlash('Enter your new password below');
			$this->redirect('/users/newpassword/'.$passTicket['User']['id']);
		}else{
			$this->Session->setFlash(__('Your ticket is no longer available.',true), 
											'default', 
											array('class' => 'flash_error'));
			$this->redirect('/');
		}
 
	}
 
    /**
   	 *  Get new password after ticket confirmation by e-mail
   	 *  based on Code from http://edwardawebb.com/programming/php-programming/cakephp/reset-lost-passwords-cakephp
	 *
	 */
	 
	function newpassword($id = null) {
		$this->pageTitle = 'Enter new Password';
		$this->layout = 'default_page'; 
		if (!$this->Session->check('tokenreset')) {
			$this->Session->setFlash('banned!?');
			$this->redirect('/');
		}
 
		if (empty($this->data)) {
			if ($this->Session->check('tokenreset')) 
				$id=$this->Session->read('tokenreset');
			if (!$id) {
				$this->Session->setFlash('Invalid id for User');
				$this->redirect('/');
			}
			$this->data = $this->User->read(null, $id);
			$this->data['User']['passwd'] =null;
			$this->data['User']['password'] =null;
		} else {				
			$this->data['User']['id'] =$id;
 			if (isset($this->data['User']['passwd']))
					$this->data['User']['passwdhashed'] = $this->Auth->password($this->data['User']['passwd']);

			$this->User->id = $id;
			if ($this->User->saveField('password', $this->data['User']['passwdhashed'],$validate = false)) {
				//delete session token and delete used ticket from table
				$this->Session->delete('tokenreset');
				$this->Session->setFlash(__('Your password has been changed',true) , 
												'default', 
												array('class' => 'flash_success'));
				//$this->redirect('/');
			} else {
				$this->Session->setFlash(__('Your password could not be changed.',true), 
												'default', 
												array('class' => 'flash_error'));
			}
		}
	}

    /**
   	 *  delete user, all his data and send him to logout
   	 *  
	 *
	 */	
	 
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('We could not find this user.',true), 
											'default', 
											array('class' => 'flash_error'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->delete($id, $cascade = true)) {
            $this->Session->write('goodbye',true);
			//$this->Session->setFlash(__('Der Benutzer und alle Hinweise wurde gelöscht', true));
			$this->redirect(array('action'=>'logout'));
		}
	
	}



}
?>