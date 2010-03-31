<?php
/**
 * Mark-a-Spot Details View
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
echo $validation->bind('Comment',array('form'  => '#CommentCommentsaddForm'));
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
		__('View details', true),
		array(
			'controller'=>'markers',
			'action'=>'view',
			'id'=>$this->params['pass'][0]),
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
	
<?php	
/*
	echo 'Previous version was made by '.$users[$undo_rev['Marker']['user_id']].' at '.$time->nice($undo_rev['Marker']['version_created']); 
echo $html->link('Undo', array('action'=>'undo',$marker['Marker']['id'])); 
echo '<h4>Versionshistorie</h4><ul>'; 
$nr_of_revs = sizeof($history); 
foreach ($history as $k => $rev) { 
    echo '<li>'.($nr_of_revs-$k).' '.$rev['Marker']['version_created'].' '. 
       $html->link('make current', array('action'=>'makeCurrent',$marker['Marker']['id'],$rev['Marker']['version_id'])); 
}  
echo '</ul>';
*/
?>


<div id="content">
	<h2 id="h2_title"><?php echo $marker['Marker']['subject'];?></h2>
	<?php echo $this->element('ajaxlist_element'); ?>
	<hr class="hidden"/>
	<div id="details">
		<h3 id="h3_detail"><?php __('Details');?></h3>
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
						echo ' '.$html->link(__('delete', true), array('action' => 'delete', $marker['Marker']['id']),array('class'=>'link_delete'), sprintf(__('Are you sure to delete marker # %s?', true), $marker['Marker']['id']));
					} 
					?>
			</div>
			<?php if ($marker['Processcat']['id'] == 1) {?>
				<dl class="color_<?php echo $marker['Processcat']['hex'];?>">
				<dt class="marker_kat"><?php __('Status'); ?></dt>
				<dd><?php __('Marker registered');?></dd>
				</dl>
			<?php } else { ?>
			<dl class="color_<?php echo $marker['Processcat']['hex'];?>">
				<dt class="marker_kat"><?php __('Category'); ?></dt>
				<dd class="<?php echo $marker['Cat']['hex']; ?>">
					<?php echo $marker['Cat']['name']; ?>
				</dd>
				<dt class="marker_status"><?php __('Status'); ?></dt>
				<dd class="status_<?php echo $marker['Processcat']['hex'];?>">
					<span><?php echo $marker['Processcat']['name']; ?></span>
				</dd>
			
				<dt class="marker_hint"><?php __('Description'); ?></dt>
				<dd class="marker_hint_text">
					<?php echo $marker['Marker']['hint']; ?>
				</dd>
			
				<dt class="marker_adress"><?php __('Address'); ?></dt>
				<dd class="marker_adress_text">
					<?php echo $marker['Marker']['street']; ?>
				</dd>		
			</dl>
			<?php } ?>
	</div>
	<div id="hint_meta">
		<small><?php __('added: '); ?> <?php echo $datum->date_de($marker['Marker']['created']) ?> <?php __('by '); ?> <?php echo $marker['User']['nickname']; ?> | <?php __('last edited on'); ?>	<?php echo $datum->date_de($marker['Marker']['modified']) ?></small>
	</div>
	<div id="ratings">
		<h3><?php __('Rating');?></h3>
			<?php  echo $this->element('rating', array('plugin' => 'rating', 'model' => 'Marker', 'id' => $marker['Marker']['id'])); ?>
	</div>

	<hr class="hidden"/>
	<?
	/*
	 * comments view and form
	 *
	 */
	echo $this->element('form_comments'); 
	?>
</div>

<div id="sidebar">
	<div>
			<!--  Raw HTML content: [begin] -->
			<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style">
<a href="http://www.addthis.com/bookmark.php?v=250&amp;pub=xa-4a51f46c045b889e" class="addthis_button_compact">Bookmark</a>
<span class="addthis_separator">|</span>
<a class="addthis_button_facebook"></a>
<a class="addthis_button_myspace"></a>
<a class="addthis_button_google"></a>
<a class="addthis_button_twitter"></a>
</div>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js?pub=xa-4a51f46c045b889e"></script>
<!-- AddThis Button END --></div>
	<h3 id="h3_map"><?php __('Map view');?></h3>
	<div id="maps">
		<div id="map_wrapper_small"><noscript><div><img alt="<?php __('Map view');?>" src="http://maps.google.com/staticmap?center=.<?php echo $googleCenter?>&amp;zoom=14&amp;size=330x330&amp;maptype=mobile\&amp;markers=<?php echo $marker['Marker']['lat'].', '.$marker['Marker']['lon']?>,blues%7C&amp;key=<?php echo $googleKey?>&amp;sensor=false"/></div></noscript></div>
	</div>
	<hr class="hidden"/>
	<h3 id="h3_photos"><?php __('Photos');?></h3>
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
	 

	if ($userGroup == $uGroupSysAdmin) {
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
