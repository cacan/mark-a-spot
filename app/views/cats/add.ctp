<div class="cats form">
<?php echo $form->create('Cat');?>
	<fieldset>
 		<legend><?php __('Add Cat');?></legend>
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
		<li><?php echo $html->link(__('List Cats', true), array('action' => 'index'));?></li>
	</ul>
</div>
