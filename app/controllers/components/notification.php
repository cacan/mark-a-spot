<?php
class NotificationComponent extends Object {

	var $name = 'Notification';
	var $components = array('Email', 'Auth', 'Session');
	var $uses = 'User';
	
	
	function startup(&$controller) {
		$this->Controller =& $controller;
		$this->Email->replyTo = 'noreply@'.Configure::read('Site.domain');
		$this->Email->from = Configure::read('Site.admin.name').'<'.Configure::read('Site.e-mail').'>';
		$this->Email->sendAs = 'text';      
	}


	/**
	* Benachrichtigung über eine neue Nachricht versenden.
	* 
	* @param integer $markerId markerId
	* @param string $template elements/email
	* @param string $recipient Empfänger
	*/
	function sendMessage($template, $markerId, $recipient) {

		$sent = false;
		
		$this->Email->to = $recipient;
		$this->Email->subject = Configure::read('e-mail.'.$template.'.subject');
		$this->Email->template = $template;

		$hashyToken = md5(date('mdY').rand(2000000,4999999));
		// write to session to use it in users_controller
		$this->Session->write('hashyToken', $hashyToken);		
		$this->Controller->set('hashyToken', $hashyToken);
		
		//Update
		$this->Controller->{$this->Controller->modelClass}->Processcat->recursive = -1;
		$this->Controller->set('processcat',
			$this->Controller->{$this->Controller->modelClass}->Processcat->read('Name',
			$this->Controller->data['Marker']['processcat_id']));
		if ($template == "update") {
			$this->Controller->set('comment', $this->Controller->data['Comment'][0]['comment']);
		}
		$this->Controller->set('user', $this->Auth->user('nickname'));
		
		// Only query User if asked out of markers_controller.php
		if ($markerId) {
			$this->Controller->set('userId', $this->Controller->{$this->Controller->modelClass}->User->id);
		}
		
		$this->Controller->set('markerId', $markerId);
		$this->Controller->set('sitename',Configure::read('Site.domain'));

		// Email senden
		if ($this->Email->send()) {
			$sent = true;
		} else {
			$sent = false;
		}
		return $sent;
	}

}
?>