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
<ul>
	<li><?php echo $this->Html->link("学生の登録",array('controller' => 'student','action' => 'std_register')); ?></li>
</ul>
<ul>
	<li><?php echo $this->Html->link("先生の登録",array('controller' => 'teachers','action' => 'register')); ?></li>
</ul>
</div>