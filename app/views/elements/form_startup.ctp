<?php
echo $form->input('Marker.subject', array('div' => 'input text required', 'before' => __('<div>Enter a short subject</div>',true), 'maxlength'=>'128', 'label' => __('Subject',true)));
echo $form->input('Marker.street', array('div' => 'input text required', 'before' => __('<div>Enter address or drag marker</div>',true), 'label' => __('Address',true)));
echo $form->input('Marker.zip', array('div' => 'input text required', 'maxlength'=>'5', 'label' => __('Zip',true)));
echo $form->input('Marker.hint', array('div' => 'input text required', 'label' => __('Describe the situation',true)));
echo '<div id="addFormMedia"><a id="showLink" href="#addFormMedia">'.__('Add some images or media?', true).'</a>';
echo '<div id="addFormMediaDiv">';
echo $this->element('attachments', array('plugin' => 'media', 'model' => 'Marker'));
echo '</div>';	
echo '</div>';	

echo $form->input('Marker.cat_id',array('div' => 'input text required', 'before' => __('<div>Please take a look at the categories</div>',true), 'label' => __('Category',true), 'empty' => __('Please choose',true)));
echo $form->input('Marker.processcat_id',array('label' => __('Status',true), 'disabled' => true));

if (!$session->read('Auth.User.id')) {
	echo $form->input('User.email_address',array('div' => 'input text required', 'label' => __('E-Mail',true), 'between'=>'<br/>', 'class'=>'text'));
	echo $form->input('User.nickname',array('div' => 'input text required', 'label' => __('Nickname',true), 'between'=>'<br/>', 'class'=>'text'));
	echo $form->input('User.password' ,array('div' => 'input text required', 'label' => __('Password',true), 'between'=>'<br/>', 'class'=>'text'));
	echo $form->input('User.passwd',array('div' => 'input text required', 'label' => __('Password Repeat',true), 'between'=>'<br/>', 'class'=>'text'));
	echo '<div id="addFormPersonals"><a id="showLink" href="#addFormPersonals">'.__('Want to tell us more about you?', true).'</a>';
	
	echo '<div id="addFormPersonalsDiv">';
	echo $form->input('User.sirname',array('label' => __('Sirname',true), 'between'=>'<br/>', 'class'=>'text'));
	echo $form->input('User.prename',array('label' => __('Name',true), 'between'=>'<br/>', 'class'=>'text'));
	echo $form->input('User.fon',array('label' => __('Phone',true), 'between'=>'<br/>', 'class'=>'text'));
	echo '</div>';	
	echo '</div>';	
	//$recaptcha->display_form('echo');

}
?>
	