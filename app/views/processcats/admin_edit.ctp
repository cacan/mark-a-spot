<div class="processcats form">
<?php echo $form->create('Processcat');?>
	<fieldset>
 		<legend><?php __('Edit Processcat');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('parent_id');
		echo $form->input('lft');
		echo $form->input('rght');
		echo $form->input('name');
		echo $form->input('hex');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('Processcat.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Processcat.id'))); ?></li>
		<li><?php echo $html->link(__('List Processcats', true), array('action' => 'index'));?></li>
	</ul>
</div>
