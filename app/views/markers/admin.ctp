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
		__('Administrate marker', true),
		array(
		'controller'=>'markers',
		'action'=>'admin'),
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
		<h2 id="h2_title"><?php __('Administration of markers');?></h2>
		<?php echo $this->element('ajaxlist_element'); ?>
			<div class="actions"><h4 class="hidden"><?php __('Actions');?></h4>
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
			</div>
		<?php echo $form->create('Markers', array('enctype' => 'multipart/form-data', 'action' => 'admin'))?>	
		<fieldset>
	 		<legend><?php __('Enter Information');?></legend>
				<?php
				echo $form->input('Marker.id', array("type" => "hidden","value" => $this->params['pass'][0]));
				
				echo $form->input('Marker.subject', array('maxlength'=>'128', 'label' => __('Subject',true)));
				echo $form->input('Marker.street', array('label' => __('Address',true)));
				echo $form->input('Marker.zip', array('maxlength'=>'5', 'label' => __('Zip',true)));
				
				echo $form->input('Marker.hint', array('label' => __('Description',true)));
				echo $this->element('attachments', array('plugin' => 'media', 'model' => 'Marker'));
				echo $form->input('Marker.cat_id',array('label' => __('Category',true), 'empty' => 'Please choose'));
				echo $form->input('Marker.processcat_id',array('label' => __('Status of Administration',true), 'disabled' => false));
				echo $form->hidden('Comment.0.name', array('value'=>$currentUser['User']['nickname'])); 
				echo $form->input('Marker.notify', array('type' => 'checkbox', 'label' => __('Notify User',true),'checked'=>'checked'));
				echo $form->hidden('Comment.0.email', array('value'=>$currentUser['User']['email_address'])); 
				echo $form->input('Marker.admincomment', array('type' => 'textarea', 'label' => 'Comment', 'value'=>''));
				echo $form->input('Comment.0.status', array('type' => 'hidden', 'value'=>'1'));

				
				?>
			</fieldset>
				<?php 
				
				echo '<p>';
				echo $html->tag('button', __('<span>Save information</span>',true), array('type' => 'submit'));
				echo '</p>';
				echo $form->end();?>
				
		<h3 id="h3_comments"><?php __('Comments');?></h3>
		
		<?php if (!empty($comments)):?>
			<?php
				$i = 0;
				foreach ($comments as $comment):
				   $class = null;
					if ($i++ % 2 == 0) {
						$class = ' class="altrow"';
					}
		
				
				if ($comment['Comment']['group_id'] == $uGroupAdmin) {
					$commentsClass ='marker_comment_admin';
				} else {
					$commentsClass="marker_comment";
				}
				?>
				<div id="comment_<?php echo $comment['Comment']['id']; ?>" title="<?php echo $comment['Comment']['id']; ?>" class="<?php echo $commentsClass ?>">
				<?php 
				switch ($comment['Comment']['status']) {
				  case "1":
				    $linktext = __('block',true);
				    $commentAdminClass = "c_published";
			        break;

				  case "0":
				    $linktext = __('publish',true);
				    $commentAdminClass = "c_hidden";
			        break;

				 }

				
				?><div class="comment_admin"><a class="comment_publish" id="publish_<?php echo $comment['Comment']['id']; ?>"href="#"><?php echo $linktext?></a> <a class="comment_delete" id="delete_<?php echo $comment['Comment']['id']; ?>" href="#"><?php echo 'delete';?></a></div>
					<p class="<?php echo $commentAdminClass; ?>"><?php echo $comment['Comment']['comment'];?></p>
					<small class="comment_meta">schrieb <?php echo $comment['Comment']['name'];?> am <?php echo $datum->date_de($comment['Comment']['created'],1);?></small>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	
				
				
	</div>
	<div id="sidebar">
		<h3 id="h3_map"><?php __('Map view');?></h3>
		<p><?php echo __('Please drag the Marker to a desired position or just edit street and zip details',true);?></p>
	
		<div id="map_wrapper_add"><noscript><div><img alt="Kartendarstellung des Hinweises" src="http://maps.google.com/staticmap?center=.<?php echo $googleCenter?>&amp;zoom=14&amp;size=230x230&amp;maptype=mobile\&amp;markers=<?php echo $marker['Marker']['lat'].', '.$marker['Marker']['lon']?>,blues%7C&amp;key=<?php echo $googleKey?>&amp;sensor=false" /></div></noscript></div>
	

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
		echo '<p>Vorherige Version: '.$undo_rev['Marker']['version_created']. ' ' .
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
