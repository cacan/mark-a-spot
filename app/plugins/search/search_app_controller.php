<?php
class SearchAppController extends AppController
{
	function beforeFilter(){
	
	
		Configure::load('mark-a-spot');
		$this->set('googleCenter',Configure::read('Google.Center'));
		$this->set('googleKey',Configure::read('Google.Key'));
		$this->loadModel('Marker');		
		$this->set('markerSum', $this->Marker->find('count'));
		$this->loadModel('Comment');
	   	
	   	$this->set('commentSum', $this->Comment->find('count'));
	   	$this->loadModel('Rating');

	   	$this->set('ratingSum', $this->Rating->find('count'));

	   	$this->set('commentLast', $this->Comment->find('first', array('order' => array('Comment.created DESC'))));
	   	$this->set('markerLast', $this->Marker->find('first', array('order' => array('Marker.created DESC')))); 
		$this->set('ratingLast', $this->Rating->find('first', array('order' => array('Rating.created DESC')))); 
	}
}
?>