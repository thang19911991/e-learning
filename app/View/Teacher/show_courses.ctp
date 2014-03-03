<div class="index">
<h2>コースリストを見る</h2>
<?php if(!$courses): ?>
	<?php echo "khong ton tai id"; ?>
<?php else: ?>
<table>
	<tr>
		<th>ID</th>
		<th>コース名</th>
		<th>作成者</th>
		<th>操作</th>
	</tr>	
	<?php foreach ($courses as $c): ?>
		<tr>
			<td><?php echo $c['Course']['id']; ?></td>
			<td><?php echo $c['Course']['course_name']; ?></td>
			<td><?php echo $teacher_name; ?></td>
			<td>
				<?php echo $this->Html->link("見る",array('controller' => 'teacher','action' => 'view_a_course', $c['Course']['id'])) ?>				
				<?php echo $this->Html->link("削除",array('controller' => 'teacher','action' => 'delete_course', $c['Course']['id'])) ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>
<?php endif;?>

</div>

<div class="actions">
	<ul>
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