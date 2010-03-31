<div class="processcats form">
<?php echo $form->create('Processcat');?>
	<fieldset>
 		<legend><?php __('Add Processcat');?></legend>
	<?php
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
		<li><?php echo $html->link(__('List Processcats', true), array('action' => 'index'));?></li>
	</ul>
</div>
