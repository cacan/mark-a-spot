	<h3 id="h3_comments"><?php __('Comments');?></h3>
	<div id="comments">

		<?php if (!empty($marker['Comment'])):?>
		<?php
			$i = 0;
			foreach ($marker['Comment'] as $comment):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
	
			if ($comment['group_id']==$uGroupAdmin) {
				$commentsClass ='marker_comment_admin';
			} else {
				$commentsClass="marker_comment";
			}
			?>
			<div class="<?php echo $commentsClass ?>">
				<p><?php echo $comment['comment'];?></p>
				<small class="comment_meta"><?php echo __('wrote',true).' '.$comment['name'].' '.__('on',true).' '.$datum->date_de($comment['created'],1);?></small>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
		<div id="comments_form">
			<?php echo $form->create('Comment',array('action' => 'commentsadd'));?>
				<fieldset>
			 		<legend><?php __('Add Comment');?></legend>
				<?php
					echo $form->hidden('marker_id', array('value'=>$marker['Marker']['id'])); 
					if (!$session->read('Auth.User.id')) {
						echo $form->input(__('name',true), array('div' => 'input text required', 'label'  => 'Name'));
						echo $form->input(__('email',true), array('div' => 'input text required', 'label'  => 'E-Mail')); }
					else {
						echo $form->input(__('name',true), array('label'  => 'Name', 'value'=>$currentUser['User']['nickname']));
						echo $form->input(__('email',true), array('label'  => 'E-Mail', 'value'=>$currentUser['User']['email_address']));
					}
					echo $form->input(__('comment',true), array('div' => 'input text required', 'label'  => 'Comment'));
				?>
				</fieldset>
			<?php echo '<p>'.$html->tag('button', '<span>'.__('Save Comment',true).'</span>', array('type' => 'submit')).'</p>';?>
			<?php echo $form->end();?>
		</div>
	</div>
	<hr class="hidden"/>
	