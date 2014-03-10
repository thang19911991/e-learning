<div class="index">
<h2>作成した授業リスト</h2>
<br>
<table width="100%">
<tr>
	<th width="40%"><h3>授業名</h3></th>
	<th width="20%"><h3>作成日</h3></th>
	<th width="30%"><h3>作成者</h3></th>
	<th width="10%"><h3>操作</h3></th>
</tr>
<?php
	$count = 0;
	foreach ( $data as $course ) {
		?>
<tr id=<?php echo "course".$count?>>
	<td>
	<?php 
		$count++;
		echo $course['Course']['course_name'];
	?>
	</td>
	<td>
	<?php 
		echo $course['Course']['created_date'];
	?>
	</td>
	<td>
	<?php 
		echo $course['User']['username'];
	?>
	</td>
	<td>
	<?php 
		echo $this->Html->link( "編集", array (
				'controller' => 'teachers',
				'action' => 'edit_course',$course['Course']['id'] ));
	?>
	<?php 
		echo $this->Html->link( "削除", array (
				'controller' => 'teachers',
				'action' => 'delete_course',$course['Course']['id'] ));
	?>
	</td>
</tr>
		<?php 
	}
?>
</table>
</div>