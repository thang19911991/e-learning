
<style>
.title {
	color: #ffffff;
background-color: #555555;
border: 1px solid #555555;
}

.action li {

float: left;
}

.action {
list-style-type: none;
}

.action a {
//  padding: 5px 15px;
//    background: #4479BA;
//    color: #FFF;	
}
.attr {
	width: 300;
}

table,th,td
{
	//colspan: 2;
	border:1px solid gray;
	border-collapse:collapse
}
</style>

<?php if($is_valid_user) {?>

<div class="users index">

	<table>
	<col width="200">
  	<col width="400">
	<tr class ='title'>
		<th class = 'attr'>Attribute</th>
		<th>Value</th>		
	</tr>
	<tr>
		<th>Id</th>
		<th><?php echo $user['User']['id']?></th>		
	</tr>
	
	<tr>
		<th>Username</th>
		<th><?php echo $user['User']['username']?></th>		
	</tr>
	<tr>
		<th>Full name</th>
		<th><?php echo $user['User']['full_name']?></th>		
	</tr>
	<tr>
		<th>Role</th>
		<th><?php echo $user['User']['role']?></th>		
	</tr>
	<tr>
		<th>Active Status</th>
		<th><?php echo $user['User']['active_status']?></th>		
	</tr>
	
	<tr>
		<th>Login Status</th>
		<th><?php echo $user['User']['login_status']?></th>		
	</tr>
	
	
	<tr>
		<th>Email</th>
		<th><?php echo $user['User']['email']?></th>		
	</tr>
	
	
	<tr>
		<th>Birthday</th>
		<th><?php echo $user['User']['birthday']?></th>		
	</tr>
	<tr>
		<th>Credit Number</th>
		<th><?php echo $user['User']['credit_number']?></th>		
	</tr>
	<?php if($user['User']['role'] == 'student') {?>
	<tr>
		<th>Additional Infor</th>
		<th><?php echo $user['Student']['additional_info']?></th>		
	</tr>
	<?php } else {?>
	<tr>
		<th>Additional Infor</th>
		<th><?php echo $user['Teacher']['additional_info']?></th>		
	<?php }?>
	</tr>
	<tr>
		<td colspan= "2" >
			<ul class = 'action'>
				<li><a href = '#'>Edit</a></li>
				<?php if($user['User']['active_status'] == 'inactive') 
				echo "<li>". $this->Html->link( "Active", array('action'=>'active_user', 'controller' => 'admins','id' => $user['User']['id']),array(),"Are you sure to active this user")."</li>" ?>
				<li><?php echo $this->Html->link( "Delete", array('action'=>'delete_user', 'controller' => 'admins','id' => $user['User']['id']),array(),"Are you sure to delete this user"); ?></li>
				
			</ul>
		</td>
		
	</tr>
	
	
	
</table>
</div>
<?php } else {
	echo '<h2>Invalid User</h2>';
	
}?>



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

