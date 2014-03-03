<div class="members index">
<h2>メンバ一覧</h2>

<?php echo "ユーザ名 : ".$current_user['username']; ?>
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
			<?php echo $this->Html->link( "コースリストを見る",   array('controller' => 'teacher', 'action'=>'show_courses')); ?>
		</li>
		<li>
			<?php echo $this->Html->link( "コース作成",   array('controller' => 'teacher', 'action'=>'add_course')); ?>
		</li>
		<li>
		<?php if($current_user): ?>
		<?php echo $this->Html->link( "ログアウト", array('controller' => 'teacher', 'action'=>'logout')); ?>
		<?php endif; ?>
		</li>
	</ul>
</div>