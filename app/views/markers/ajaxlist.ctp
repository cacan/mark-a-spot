<?php
/**
 * Mark-a-Spot Ajaxlist Action
 *
 * Show table with markers and ajax pagination
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
?>
<script type="text/javascript">
$(document).ready(function() {

	$("a.lightbox").fancybox();
		

  	$('a.link_view').wrapInner(document.createElement("span"));
  	$('a.link_edit').wrapInner(document.createElement("span"));
  	$('a.link_delete').wrapInner(document.createElement("span"));
  	$('.close>a').click(function() {
  		$("#tabAll").fadeOut('slow'); 
  		$('input#toggletab').attr("checked", ""); 
  		$("#tabMy").fadeOut('slow'); 
  		$('input#toggletab').attr("checked", ""); 
  	});
//  	if ($('#tab').is(':block')) {
		$('td.actions>a').hide();
	    $('tr').hover(
	    	function() {
	    		$(this).children('.actions').children().show()
	    	}, 
	    	function() {
	    		$(this).children('.actions').children().hide()
	    	});
//	}

	$('a.link_delete').click(function(e) {
			e.preventDefault();
			var parent = $(this).parent().parent();
			$.ajax({
				type: 'get',
				url: '/markers/delete/'+ parent.attr('id'),
				beforeSend: function() {
					parent.animate({'backgroundColor':'#fb6c6c'},1300);
				},
				success: function() {
					parent.slideUp(300,function() {
						parent.remove();
					});
				}
			});
		});
});
</script>


		<div id="tabList">
		<div class="close"><a href="#"><span><?php __('close')?></span></a></div>
		<form id="tabFilter">
			<fieldset id="tabCat"><legend><?php __('Filter List');?></legend>
			<label for="listCatSelect"><?php __('Choose category');?></label>	
			<?php
				echo '<select id="listCatSelect">';
				echo '<option>'.__('Choose category',true).'</option>';
				foreach ($cats as $cat):
				if ($cat['Cat']['id'] == $getIdCat) {
					$selected = ' selected = "selected" ';
				} else {
					$selected = '';
				}
				echo '<option class="cat_'.$cat['Cat']['hex'].'"'.$selected.' value="'.$html->url(array('controller'  => '/markers', 'action' => 'ajaxlist', 'cat' =>$cat['Cat']['id'])).'">'.$cat['Cat']['name'].'</option>';
				endforeach; 
				echo '</select>';
			?>
			</fieldset>
				
			<fieldset id="tabProcesscat">
			<label for="listProcesscatSelect"><?php __('Choose status');?></label>	
			
			<?php
				echo '<select id="listProcesscatSelect">';
				echo '<option>'.__('Choose status',true).'</option>';

				foreach ($processcats as $processcat):
				if ($processcat['Processcat']['id'] == $getIdProcesscat) {
					$selected = ' selected = "selected" ';
				} else {
					$selected = '';
				}
				echo '<option class="status_'.$processcat['Processcat']['hex'].'"'.$selected.' value="'.$html->url(array('controller'  => '/markers', 'action' => 'ajaxlist', 'processcat' =>$processcat['Processcat']['id']), array('id'=>'processCond_'.$processcat['Processcat']['id'])).'">'.$processcat['Processcat']['name'].'</option>';
				endforeach; 
				echo '</select>';
			?>
			</fieldset>
		</form>
<?php
		echo $paginator->counter(array(
		'format' => __('Page %page% of %pages% | %current% Markers of %count%', true)
		));
		?>
		<h3><?php __('List view of Markers')?></h3>
		
				
		
		
		<table cellpadding="0" cellspacing="0">
		<tr id="sortUser">
			<th><?php echo $paginator->sort(__('Subject',true), 'Marker.subject');?></th>
			<th><?php echo $paginator->sort(__('Choose Category',true), 'Cat.name');?></th>
			<!-- th><?php //echo $paginator->sort(__('District',true), 'District.id');?></th -->
			<th><?php echo $paginator->sort(__('Status',true), 'Processcat.name');?></th>
			<th><?php echo $paginator->sort(__('Rating',true), 'Marker.rating');?></th>
			<th><?php echo $paginator->sort(__('Modified',true), 'Marker.modified');?></th>
			<th class="actions"><span><?php __('View, Edit, Delete')?></span></th>
		</tr>
		<?php
		$i = 0;
		if (!$markers) {
			echo  __('No Markers found',true);
		}
		foreach ($markers as $marker):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
			<tr id="<?php echo $marker['Marker']['id']?>">
				<td class="subject">
					<?php echo $html->link($marker['Marker']['subject'], array('action' => 'view', $marker['Marker']['id'])); ?><br/><span><?php echo $marker['User']['nickname']; ?></span>
					<a class="lightbox map" href="http://maps.google.com/staticmap?.jpg&amp;center=<?php echo $marker['Marker']['lat'].','.$marker['Marker']['lon']?>&amp;zoom=14&amp;size=330x330&amp;maptype=mobile\&amp;markers=<?php echo $marker['Marker']['lat'].','.$marker['Marker']['lon']?>,blues%7C&amp;key=<?php echo $googleKey?>&amp;sensor=false"><span><?php __('Show in Map')?><span></a>
				</td>
				<td>
					<?php echo $marker['Cat']['name']; ?>
				</td>
				<!-- td class="district">
					<a href="#" onClick="map.setCenter(<?php echo $marker['District']['lat']; ?>,<?php echo $marker['District']['lon']; ?>)"><?php echo $marker['District']['name']; ?></a>
				</td -->
				<td class="color_<?php echo $marker['Processcat']['hex']; ?>">
					<?php echo $marker['Processcat']['name']; ?>
				</td>
				<td class="rating">
					<?php //echo $marker['Marker']['rating']?>
					<?php  echo $marker['Marker']['rating']//echo $this->element('rating', array('plugin' => 'rating', 'model' => 'Marker', 'id' => $marker['Marker']['id'])); ?></td>

				<td class="date">
					<?php echo $datum->date_de($marker['Marker']['modified'],1);?> </td>
				<td class="actions">
					<?php echo $html->link(__('Details', true), array('action' => 'view', $marker['Marker']['id']),array('class'=>'link_view')); ?>
					<?php 
					// gehoert der Marker diesem User?
					if ($marker['Marker']['user_id'] == $session->read('Auth.User.id')) {	
						echo $html->link(__('edit', true), array('action' => 'edit', $marker['Marker']['id']),array('class'=>'link_edit')); }
					 else if ($userGroup == $uGroupAdmin || $userGroup == $uGroupSysAdmin) {	
						echo $html->link(__('administrate', true), array('action' => 'admin', $marker['Marker']['id']),array('class'=>'link_edit'));
					 }
					// gehoert der Marker diesem User?
					if ($marker['Marker']['user_id'] == $session->read('Auth.User.id') || $userGroup == $uGroupAdmin || $userGroup == $uGroupSysAdmin) {	
						echo $html->link(__('delete', true), array('action' => 'delete', $marker['Marker']['id']),array('class'=>'link_delete'), sprintf(__('Are you to delete Marker with # %s?', true), $marker['Marker']['id']));
					} 
					?>
				</td>
			</tr>

		<?php endforeach; ?>
		</table>
		<div id="pagination">
				<?php echo $paginator->prev('<< '.__('Previous Page', true), array(), null, array('class'=>'disabled'));?>
			 | 	<?php echo $paginator->numbers();?>
				<?php echo $paginator->next(__('Next page', true).' >>', array(), null, array('class' => 'disabled'));?>
		</div>