<?php
/**
 * Mark-a-Spot List.Action
 *
 * Show accessible list with markers and pagination
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
?>
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
			__('List',true),
		array(
		'controller'=>'markers',
		'action'=>'liste'),
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

<div id="content" class="page form">
	<div class="markers index">
	<?php if ($h2Cat) {?>
		<h2 style=""><?php __('Markers by category: ', true ).$h2Cat;?></h2>
		<?php echo $this->element('ajaxlist_element'); ?>
	<?php } else if ($h2Processcat) {?>
		<h2 style=""><?php __('Markers by status: ',true).$processcat['Processcat']['Name'];?></h2>
		<?php echo $this->element('ajaxlist_element'); ?>
	<?php } else {?>
		<h2 style=""><?php __('All markers');?></h2>
		<?php echo $this->element('ajaxlist_element'); ?>
	<?php } ?>
			<div id="tabAll">
				<div id="markerList" class="ui-widget-content ui-state-default"></div> 
			</div>
			<div id="tabMy">
				<div id="markerMyList" class="ui-widget-content ui-state-default"></div> 
			</div>
			<noscript>
			<div id="listNoscript">
				<?php
				echo $paginator->counter(array(
				'format' => __('Page %page% of %pages% | %current% Markers of %count%', true)
				));
				?>
				<h3><?php __('Sort markers');?></h3>
				<ul id="sortUser">
					<li><?php echo $paginator->sort(__('Subject',true), 'Marker.subject');?></li>
					<li><?php echo $paginator->sort(__('Category',true), 'Cat.name');?></li>
					<!-- li><?php //echo $paginator->sort(__('District',true), 'District.id');?></li -->
					<li><?php echo $paginator->sort(__('Status',true), 'Processcat.name');?></li>
					<li><?php echo $paginator->sort(__('Rating',true), 'Marker.rating');?></li>
					<li><?php echo $paginator->sort(__('Modified',true), 'Marker.modified');?></li>
				</ul>
				<ul class="marker_static">
				<?php
				$i = 0;
				foreach ($markers as $marker):
					$class = null;
					if ($i++ % 2 == 0) {
						$class = ' class="altrow"';
					}
				?>
						<li><img alt="<?php __('Map view');?>" src="http://maps.google.com/staticmap?center=<?php echo $googleCenter?>&amp;zoom=14&amp;size=330x330&amp;maptype=mobile\&amp;markers=<?php echo $marker['Marker']['lat'].','.$marker['Marker']['lon']?>,blues%7C&amp;key=<?php echo $googleKey?>&amp;sensor=false"/><h3><?php echo $html->link($marker['Marker']['subject'], array('action' => 'view', $marker['Marker']['id'])); ?></h3><span><?php echo $marker['User']['nickname']; ?>, gemeldet: <?php echo $datum->date_de($marker['Marker']['created'],1);?></span>						<ul>
								<li class="image_static"></li>
								<li class="cat_static"><?php echo $marker['Cat']['name']; ?></li>
								<li class="district_static"><a href="#" onclick="map.setCenter(<?php echo $marker['District']['lat']; ?>,<?php echo $marker['District']['lon']; ?>)"><?php echo $marker['District']['name']; ?></a></li>
								<li class="color_<?php echo $marker['Processcat']['hex']; ?>"><?php echo $marker['Processcat']['name']; ?></li></ul>
						</li>
						<li class="actions static">
							<?php echo $html->link(__('Details', true), array('action' => 'view', $marker['Marker']['id']),array('class'=>'link_view')); ?>
							<?php 
							// gehoert der Marker diesem User?
							if ($marker['Marker']['user_id'] == $session->read('Auli.User.id')) 	
								echo $html->link(__('edit', true), array('action' => 'edit', $marker['Marker']['id']),array('class'=>'link_edit')); ?>
							<?php 
							// gehoert der Marker diesem User?
							if ($marker['Marker']['user_id'] == $session->read('Auli.User.id')) 	
								echo $html->link(__('delete', true), array('action' => 'delete', $marker['Marker']['id']),array('class'=>'link_delete'), sprintf(__('Are you sure to delete marker # %s?', true), $marker['Marker']['id'])); 
							?><br style="clear:both"/><hr/></li>			
				<?php endforeach; ?>
				</ul>
				<div id="pagination">
				<?php echo $paginator->prev('<< '.__('Previous Page', true), array(), null, array('class'=>'disabled'));?>
			 | 	<?php echo $paginator->numbers();?>
				<?php echo $paginator->next(__('Next page', true).' >>', array(), null, array('class' => 'disabled'));?>
				</div>
			</div>	
		</noscript>
	</div>
</div>
<!-- content end -->

	<div id="sidebar" class="app">
		<div id="views"></div>
		<!---
		<h3><?php __('Choose district');?></h3>
		<div id="district">
		<form id="districtSelectForm" method="post" action="/hiernochauftabelle">
			<div>
			<?php
				echo '<select id="disctrictSelect">';
				foreach ($districts as $district):
					echo '<option class="district" value="'.$district['District']['lat'].', '.$district['District']['lon'].'">'.$district['District']['name'].'</option>';
				endforeach; 
				echo '</select>';
			?>
			</div>
		</form>
		</div>
		-->
		
		<h3><?php __('Choose category');?></h3>
		<div id="cat">	
		<?php
			echo '<ul id="catSelect">';
			foreach ($cats as $cat):
			 	echo '<li class="cat_'.$cat['Cat']['hex'].'">'.$html->link($cat['Cat']['name'], array('controller'  => '/markers', 'action' => 'liste', 'cat' =>$cat['Cat']['id']), array('id'=>'catId_'.$cat['Cat']['id'])).'</li>';
			endforeach; 
			echo '</ul>';
		?>
		</div>
			
		<h3><?php __('Choose status');?></h3>	
		<div id="processcat">
		<?php
			echo '<ul id="processcatSelect">';
			foreach ($processcats as $processcat):
			 	echo '<li class="status_'.$processcat['Processcat']['hex'].'">'.$html->link($processcat['Processcat']['name'], array('controller'  => '/markers', 'action' => 'liste', 'processcat' =>$processcat['Processcat']['id']), array('id'=>'processCond_'.$processcat['Processcat']['id'])).'</li>';
			endforeach; 
			echo '</ul>';
		?>
		</div>
	</div>

<!-- Sidebar ende-->
