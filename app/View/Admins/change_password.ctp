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
<div class="actions">
<ul>
<li><h3>Hello, Admin <?php echo $current_user['username']?></h3></li>
<li><?php echo $this->Html->link( "Student Manager",   array('controller' => 'admins', 'action'=>'student_manager')); ?></li>
<li><?php echo $this->Html->link( "Teacher Manager",   array('controller' => 'admins', 'action'=>'teacher_manager')); ?></li>
<li><?php echo $this->Html->link( "Add a new Admin",   array('controller' => 'admins', 'action'=>'create_admin')); ?></li>
<li><?php echo $this->Html->link( "Admin Profile",   array('controller' => 'admins', 'action'=>'view_profile')); ?></li>
<li><?php echo $this->Html->link( "Logout", array('action'=>'logout', 'controller' => 'users')); ?></li>
<li></li>
</ul>
</div>
