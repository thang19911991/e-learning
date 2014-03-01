<div class="users form">
<h2>Add a New User</h2>
<?php 
	var_dump($current_user);
	echo $this->Form->create("User");
	echo $this->Form->input('username');
	echo $this->Form->input('password');
	echo $this->Form->input('role');
	echo $this->Form->end("Register",array('action' => 'register'));
?>
</div>