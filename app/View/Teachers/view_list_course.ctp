<div>
<h1>
作成した授業リスト
</h1>
<br>
<table width="100%">
<tr>
	<th width="40%"><h3>授業名</h3></th>
	<th width="40%"><h3>作成日</h3></th>
	<th></th>
</tr>
<?php 
//	debug($data);
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
		echo $this->Html->link( "編集", array (
				'controller' => 'Teachers',
				'action' => 'edit_course',$course['Course']['id'] ));
	?>
	<?php 
		echo $this->Html->link( "削除", array (
				'controller' => 'Teachers',
				'action' => 'delete_course',$course['Course']['id'] ));
	?>
	</td>
</tr>
		<?php 
	}
?>
</table>
</div>

<script type="text/javascript">
	function deleteCourse(){
		var data;
		$.ajax({
			url : '<?php echo $this->base.'/teachers/index'?>',
			type : 'POST',
			data : {data : data},
			success : function(data){
				
			}
		});
	}
</script>