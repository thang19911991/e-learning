<div class="users index">
	<h2>Admin change password</h2>
	<?php
//		echo '<pre>';
//		var_dump($ad);
//		die();
		echo $this->Form->create('User');
		echo '<p>' . 'User name: ' . $ad['User']['username'] . '</p>';
		echo '<p>' . 'Full name: ' . $ad['User']['full_name'] . '</p>';
		echo $this->Form->input('Old password', array('name'=>'password','placeholder' => 'Enter your old password','type'=>'password'));
		echo $this->Form->input('New password', array('name'=>'password1','placeholder' => 'Enter new password','type'=>'password'));
		echo $this->Form->input('Confirm new password', array('name'=>'password2', 'placeholder' => 'Reenter new password', 'type'=>'password'));
		echo $this->Form->button('Clear',array('type' => 'reset'));
		echo $this->Html->link('Cancel', array('action'=>'view_profile'));
		echo $this->Form->end('Save',array('controller' => 'admins', 'action' => 'change_password'));
	?>
</div>


