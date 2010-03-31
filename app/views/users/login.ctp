<?php
/**
 * Mark-a-Spot User login
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

echo $this->element('head'); 
$javascript->link('jquery/jquery.validation.js', false); 
echo $validation->bind('User',array('form'=>'UserLoginForm'));	echo '<div id="breadcrumb"><div>';
	$html->addcrumb(
		 __('Home', true),
			'/',
			array('escape'=>false)
		);
	$html->addcrumb(
		__('Log in', true),
		array(
			'controller'=>'users',
			'action'=>'login'),
			array('escape'=>false)
	);
	echo $html->getCrumbs(' / ');
	echo '</div>';
	
		
		
	/*
	 * Welcome User with Nickname
	 *
	 */
	echo $this->element('welcome'); 
	echo '</div>';

?>
	<div id="content">
		<h2 id="h2_title"><?php __('Log in');?></h2>
		<?php echo $this->element('ajaxlist_element'); ?>
		<?php echo $this->element('ajaxlist_element'); ?>

		<div id="tabAll">
			<div id="markerList" class="ui-widget-content ui-state-default"></div> 
		</div>
			
		<?php
		echo $form->create('User', array('action' => 'login'));
		?>
		<fieldset>
		 <legend><?php __('Enter login data');?></legend>
		<?php
		echo $form->input('email_address',array('label'=>__('E-Mail',true), 'between'=>'<br/>', 'class'=>'text'));
		echo $form->input('password',array('label'=>__('Password',true), 'between'=>'<br/>', 'class'=>'text'));
		echo $form->input('remember_me', array('label' => __('Log in automatically on this computer',true), 'type' => 'checkbox'));
		echo '</fieldset>';
		echo '<p>';
		echo $html->tag('button', __('<span>Log in</span>',true), array('type' => 'submit'));
		echo '</p>';
		echo $form->end();?>

	</div>
	
	<div id="sidebar">
		<p><?php echo __('You haven&rsquo;t been here yet and want to add a marker?',true);?></p>
		<ul>
		<?php
		echo '<li>'.$html->link(__('Add a marker directly', true), array('controller' => '/', 'action' => 'startup')).'</li>';
		echo '<li>'.$html->link(__('Lost your password?', true), array('controller' => 'users', 'action' => 'resetpassword')).'</li>';
		?>
		</ul>
	<div id="map" style="visibility:hidden"></div>
	</div>