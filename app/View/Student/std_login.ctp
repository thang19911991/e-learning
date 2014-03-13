<div class="index">
<h2>ログイン</h2>
<?php 
	echo $this->Form->create("User");
	echo $this->Form->input("username");
	echo $this->Form->input("password");
	echo $this->Form->end("Login");
?>
</div>
<div class="actions">
	<?php echo $this->Html->link("Register",array('Controller' => 'student','action' => 'std_register')); ?>
</div>