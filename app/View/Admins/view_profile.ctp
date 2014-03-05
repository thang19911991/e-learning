<div class="users index">
	<h2>Admin profile</h2>
	<table>
		<tr>
			<td>Username</td>
			<td><?php echo $ad['User']['username']; ?></td> 
		</tr>
		<tr>
			<td>Full name</td>
			<td><?php echo $ad['User']['full_name']; ?></td> 
		</tr>
		<tr>
			<td>Birthday</td>
			<td><?php echo $ad['User']['birthday']; ?></td> 
		</tr>
		<tr>
			<td>Adress</td>
			<td><?php echo $ad['User']['address']; ?></td> 
		</tr>
		<tr>
			<td>Phone</td>
			<td><?php echo $ad['User']['phone']; ?></td> 
		</tr>
		<tr>
			<td>Credit number</td>
			<td><?php echo $ad['User']['credit_number']; ?></td> 
		</tr>
		<tr>
			<td>IP list</td>
			<td><?php echo $ad['Ip']['IP']; ?></td> 
		</tr>
		<tr>
			<td colspan="2">
			<p align="center">
			<?php
//				var_dump($ad);
				echo $this->Html->link("Edit Profile",array('controller' => 'admins','action' => 'edit_profile'));
				echo "\t" . $this->Html->link('Change Password', array('action'=>'change_password'));
				echo "\t" . $this->Html->link('Change IP list', array('action'=>'change_ip'));
			 ?>
			 </p>
		</tr>
	</table>
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
