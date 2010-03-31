<h2>Cache Me</h2>
		<?php echo $this->element('ajaxlist_element'); ?>

<cake:nocache>
	<p>F. In Element With No Cache Tags</p>
	<?php $this->log('6. In element with no cache tags') ?>
</cake:nocache>
