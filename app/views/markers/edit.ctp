<?php 
/**
 * Mark-a-Spot Administration View for authorities
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
 
 
echo $this->element('head');
$javascript->link('jquery/jquery.validation.js', false); 
echo $validation->bind('Marker');
?>

<?php		
	echo '<div id="breadcrumb"><div>';
	$html->addcrumb(
		 __('Home', true),
			'/',
			array('escape'=>false)
		);
	$html->addcrumb(
		__('Map', true),
		array(
			'controller'=>'markers',
			'action'=>'app'),
			array('escape'=>false)
	);
	$html->addcrumb(
		__('Edit details', true),
		array(
		'controller'=>'markers',
		'action'=>'edit'),
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
		<h2 id="h2_title"><?php __('Edit marker');?></h2>
		<?php echo $this->element('ajaxlist_element'); ?>
		<?php echo $html->link(__('Details', true), array('action' => 'view', $marker['Marker']['id']),array('class'=>'link_view')); ?>
				<?php 
					// gehoert der Marker diesem User?
					if ($marker['Marker']['user_id'] == $session->read('Auth.User.id')) {	
						echo ' '.$html->link(__('edit', true), array('action' => 'edit', $marker['Marker']['id']),array('class'=>'link_edit')); }
					 else if ($userGroup == $uGroupAdmin || $userGroup == $uGroupSysAdmin) {	
						echo ' '.$html->link(__('administrate', true), array('action' => 'admin', $marker['Marker']['id']),array('class'=>'link_edit'));
					 }
					// gehoert der Marker diesem User?
					if ($marker['Marker']['user_id'] == $session->read('Auth.User.id') || $userGroup == $uGroupAdmin || $userGroup == $uGroupSysAdmin) {	
						echo ' '.$html->link(__('delete', true), array('action' => 'delete', $marker['Marker']['id']),array('class'=>'link_delete'), sprintf(__('Are you sure to delete Marker # %s?', true), $marker['Marker']['id']));
					} 
					?>
		<?php echo $form->create('Markers', array('enctype' => 'multipart/form-data', 'action' => 'edit'))?>	
		<fieldset>
	 		<legend><?php __('Edit marker');?></legend>
			 	<?php echo $this->element('form_add_edit_admin'); ?>
			</fieldset>
				<?php 
				
				echo '<p>';
				echo $html->tag('button', __('<span>Save information</span>',true), array('type' => 'submit'));
				echo '</p>';
				echo $form->end();?>
				
			
				
				
	</div>
	<div id="sidebar">
		<h3 id="h3_map"><?php __('Map view');?></h3>
		<p><?php echo __('Please drag the Marker to a desired position or just edit street and zip details',true);?></p>
	
		<div id="map_wrapper_add"><noscript><div><img alt="<?php __('Map view');?>" src="http://maps.google.com/staticmap?center=.<?php echo $googleCenter?>&amp;zoom=14&amp;size=230x230&amp;maptype=mobile\&amp;markers=<?php echo $marker['Marker']['lat'].', '.$marker['Marker']['lon']?>,blues%7C&amp;key=<?php echo $googleKey?>&amp;sensor=false" /></div></noscript></div>
	

		<hr class="hidden"/>
	<h3><?php __('Photos');?></h3>
	<div id="media">
		<?php
		echo "<div>";
		if (!empty($marker['Attachment'])) {
			$counter=0;		
			foreach ($marker['Attachment'] as $image) {
				$counter++;
				echo '<div class="thumb">';
				echo '<a class="lightbox imageThumbView" href="/media/filter/xl/'.$image['dirname']."/".substr($image['basename'],0,strlen($image['basename'])-3).'png">'.$medium->embed("filter/s/".$image['dirname']."/".$image['basename'],array('alt' => $image['alternative'], 'title' => "title")).'</a></div>';
			}
		} else {
			echo '<div>'.__('No picture available',true).'</div>';
		}	
		echo "</div>";
	echo "</div>";
	

	/**
	 *
	 * Undo for User-Login
	 *
	 */

	if ($marker['Marker']['user_id'] == $session->read('Auth.User.id')) {
		echo '<h3>'.__('Back to last version',true).'</h3>';
		echo '<div id="undo">';
		echo '<p>'.__('Undo',true).$undo_rev['Marker']['version_created']. ' ' .
			$html->link(__('undo',true), array('action'=>'undo',$marker['Marker']['id'])).'</p>';
		echo '</div>';
	} 
	
	
	/**
	 *
	 * Versioning for Admin-Access
	 *
	 */

	if ($userGroup == $uGroupAdmin) {
		echo '<h3>'.__('Version history',true).'</h3>';
		echo '<div id="history"><ul>'; 
		$nr_of_revs = sizeof($history); 
		foreach ($history as $k => $rev) { 
	    	echo '<li>'.($nr_of_revs-$k).' '.$datum->date_de($rev['Marker']['version_created'],2).' '. 
	       	$html->link('roll back', array('action'=>'makeCurrent',$marker['Marker']['id'],$rev['Marker']['version_id'])).'</li>'; 
		}  
		echo '</ul>';
		echo '</div>';
	}
	?>
	</div>	
