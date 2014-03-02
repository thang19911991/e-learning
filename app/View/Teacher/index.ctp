<div class="members index">
<h2>List Members</h2>

<?php echo "Ten nguoi dung : ".$current_user['username']; ?>
<table>
<tr>
	<th>Id</th>
	<th>ユーザ名</th>
	<th>名前</th>
	<th>誕生日</th>
	<th>アドレス</th>
	<th>レベル</th>
</tr>
<?php foreach($users as $user): ?>
	<tr>
		<td><?php echo $user["User"]["id"]; ?></td>
		<td><?php echo $user["User"]["username"]; ?></td>
		<td><?php echo $user["User"]["full_name"]; ?></td>
		<td><?php echo $user["User"]["birthday"]; ?></td>
		<td><?php echo $user["User"]["address"]; ?></td>
		<td><?php echo $user["User"]["role"]; ?></td>
	</tr>
<?php endforeach; ?>
</table>
</div>

<div class="actions">
	<ul>
		<li>
			<?php echo $this->Html->link( "View Course",   array('controller' => 'teacher', 'action'=>'view_course')); ?>
		</li>
		<li>
			<?php echo $this->Html->link( "Add Course",   array('controller' => 'teacher', 'action'=>'add_course')); ?>
		</li>
		<li>
		<?php if($current_user): ?>
		<?php echo $this->Html->link( "Logout", array('controller' => 'teacher', 'action'=>'logout')); ?>
		<?php endif; ?>
		</li>
	</ul>
</div>