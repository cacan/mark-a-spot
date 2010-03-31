<?php
if (isset($this->params['pass'][0])) {
	echo $form->input('Marker.id', array("type" => "hidden","value" => $this->params['pass'][0]));
}

echo $form->input('Marker.subject', array('before' => __('<div>Enter a short subject</div>',true), 'maxlength'=>'128', 'label' => __('Subject',true)));
echo $form->input('Marker.street', array('label' => __('Address',true)));
echo $form->input('Marker.zip', array('maxlength'=>'5', 'label' => __('Zip',true)));
echo $form->input('Marker.hint', array('label' => __('Describe the situation',true)));
echo $this->element('attachments', array('plugin' => 'media', 'model' => 'Marker'));
echo $form->input('Marker.cat_id',array('label' => __('Choose category',true), 'empty' => __('Please choose',true)));
echo $form->input('Marker.processcat_id',array('label' => __('Status',true), 'disabled' => true));
?>