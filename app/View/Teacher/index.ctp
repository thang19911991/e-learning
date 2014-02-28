<div class="members index">
<h2>List Members</h2>

<?php echo "Ten nguoi dung : ".$current_user['username']; ?>
<table>
<tr>
	<th>Id</th>
	<th>Username</th>
	<th>Full Name</th>
	<th>Birthday</th>
	<th>Address</th>	
</tr>
<?php foreach($users as $user): ?>
	<tr>
		<td><?php echo $user["Member"]["id"]; ?></td>
		<td><?php echo $user["Member"]["username"]; ?></td>
		<td><?php echo $user["Member"]["fullname"]; ?></td>
		<td><?php echo $user["Member"]["birthday"]; ?></td>
		<td><?php echo $user["Member"]["address"]; ?></td>
	</tr>
<?php endforeach; ?>
</table>
</div>

<div class="actions">
	<ul>
		<li>
			<?php echo $this->Html->link( "Register",   array('controller' => 'members', 'action'=>'register')); ?>
		</li>
		<li>
		<?php if($current_user): ?>
		<?php echo $this->Html->link( "Logout", array('controller' => 'members', 'action'=>'logout')); ?>
		<?php endif; ?>
		</li>
	</ul>
</div>