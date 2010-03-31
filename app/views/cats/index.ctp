<div class="cats index">
<h2><?php __('Cats');?></h2>
		<?php echo $this->element('ajaxlist_element'); ?>
		<?php echo $this->element('ajaxlist_element'); ?>

<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('parent_id');?></th>
	<th><?php echo $paginator->sort('lft');?></th>
	<th><?php echo $paginator->sort('rght');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('hex');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($cats as $cat):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $cat['Cat']['id']; ?>
		</td>
		<td>
			<?php echo $cat['Cat']['parent_id']; ?>
		</td>
		<td>
			<?php echo $cat['Cat']['lft']; ?>
		</td>
		<td>
			<?php echo $cat['Cat']['rght']; ?>
		</td>
		<td>
			<?php echo $cat['Cat']['name']; ?>
		</td>
		<td>
			<?php echo $cat['Cat']['hex']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $cat['Cat']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $cat['Cat']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $cat['Cat']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $cat['Cat']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('Previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Cat', true), array('action' => 'add')); ?></li>
	</ul>
</div>
