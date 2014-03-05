<div class='users index'>
	<h2>Admin edit profile</h2>
	<?php
//		echo '<pre>';
//		var_dump($ad);
//		die();
		echo $this->Form->create('User');
		echo '<p>' . 'User name: ' . $ad['User']['username'] . '</p>';
		echo $this->Form->input('full_name');
		//echo $this->Form->input('birthday');
		echo $this->Form->input('birthday', array( 'label' => 'Date of birth'
  							, 'type' => 'date'
                            , 'dateFormat' => 'DMY'
                            , 'minYear' => date('Y') - 120
                            , 'maxYear' => date('Y')));
		echo $this->Form->input('address');
		echo $this->Form->input('phone');
		echo $this->Form->input('credit_number');
		//echo $this->Form->input('IP list', array('placeholder' => $ad['Ip']['IP']));
		echo '<p>' . 'IP list: ' . $ad['Ip']['IP'] . '</p>' ;
//		echo $this->Form->input('Old password', array('placeholder' => 'Enter your old password','type'=>'password'));
//		echo $this->Form->input('New password', array('placeholder' => 'Enter new password','type'=>'password'));
//		echo $this->Form->input('Confirm new password', array('placeholder' => 'Reenter new password', 'type'=>'password'));

		echo $this->Form->button('Clear',array('type' => 'reset'));
		echo $this->Form->button('Cancel', array('name' => 'cancel','action'=>'view_profile'));
		echo $this->Form->end('Save',array('controller' => 'admins', 'action' => 'edit_profile'));
//		echo $this->Html->link('Change Password', array('action'=>'change_password'));
//		echo $this->Html->link('Change IP list', array('action'=>'change_ip'));
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
