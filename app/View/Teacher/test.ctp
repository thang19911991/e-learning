<div class="index">
<h2>Test</h2>
<?php 
	echo $this->Form->create('User',array('url' => array('controller' => 'teacher', 'action' => 'test'), 'type' => 'file'));
	echo $this->Form->input("profile_img", array('type' => 'file', 'required' => 'false'));
	echo $this->Form->end("Upload");
?>
</div>

<div class="actions">

</div>