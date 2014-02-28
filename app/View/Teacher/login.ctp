<div class="users form">
<h2>Login</h2>
<?php
	// set flag message. Nó gửi thông báo đến tất cả các action biết
	// giả sử như khi register xong thì sẽ tự động direct đến trang 
	// login và trên trang login sẽ hiện thông báo là : You are not authorized to access that location.
	//echo $this->Session->flash('auth');
			
	echo $this->Form->create("Member");
	echo $this->Form->input('username');
	echo $this->Form->input('password');
	echo $this->Form->end("Login",array('controller' => 'members', 'action' => 'login'));
?>
</div>

<div class="actions">
	<?php echo $this->Html->link("Register",array('action' => 'register')); ?>
</div>