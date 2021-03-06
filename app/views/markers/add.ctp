<?php 
/**
 * Mark-a-Spot Add marker, if user is logged in already
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
 
echo $this->element('head'); //
$javascript->link('jquery/jquery.validation.js', false); 
echo $validation->bind(array('Marker', 'User'));
?>

<h1 class="hidden"><?php __('Add a marker');?></h1>
<?php		
	echo '<div id="breadcrumb"><div>';
	$html->addcrumb(
		__('Home',true),
			'/',
			array('escape'=>false)
		);
	$html->addcrumb(
		 __('Map',true),
		array(
		'controller'=>'markers',
		'action'=>'app'),
		array('escape'=>false)
	);
	$html->addcrumb(
		 __('Add marker',true),
		array(
		'controller'=>'markers',
		'action'=>'add'),
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
		<h2 id="h2_title"><?php __('Add your marker');?></h2>
		<?php echo $this->element('ajaxlist_element'); ?>
		<p><?php echo __('Enter details of the problem. Please note that all fields marked with "*" are mandatory.');?></p>
		<?php echo $form->create('Markers', array('enctype' => 'multipart/form-data') );?>
			<fieldset>
			 <legend><?php __('Give us some Information');?></legend>
			 	<?php echo $this->element('form_add_edit_admin'); ?>
			</fieldset>
				<?php echo $html->tag('button', '<span>'. __('Save Information',true).'</span>.', array('type' => 'submit'));?>
	</div>
	<div id="sidebar">
		<p><?php echo __('Add a streets name or drag the marker to the desired position');?></p>
		<div id="map_wrapper_add"></div>
	</div>

