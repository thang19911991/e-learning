
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
		<th>Address</th>
		<th><?php echo $user['User']['address']?></th>		
	</tr>
	<tr>
		<th>Phone Number</th>
		<th><?php echo $user['User']['phone']?></th>		
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
		<th>Course(s)</th>
		<th>
			<?php
			
			foreach ($teacher['Course'] as $course){
				echo $this->Html->link("- ".$course['course_name'], array('controller' => 'admins', 'action' => 'course_detail', 'id' => $course['id']));
			}
			?>
		</th>		
	</tr>
	
	<tr>
		<th>Additional Infor</th>
		<th><?php echo $user['Teacher']['additional_info']?></th>		
	<?php }?>
	</tr>
	<tr>
		<td colspan= "2" >
			<ul class = 'action'>
				<li><?php echo $this->Html->link('Edit', array('action' => 'edit_user_profile', 'controller' => 'admins', 'id' => $user['User']['id']))?></li>
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




