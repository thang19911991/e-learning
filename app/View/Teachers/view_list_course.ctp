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
	//var_dump($data);
	
	foreach ( $data as $course ) {
		?>
<tr>
	<td>
	<?php 
		echo $course['Course']['course_name'];
	?>
	</td>
	<td>
	<?php 
		echo $course['Course']['created_date'];
	?>
	</td>
	<td>
		<button onclick="deleteCourse();">
			Delete
		</button>
	</td>
</tr>
		<?php 
	}
?>
</table>
</div>

<script type="text/javascript">
	function deleteCourse(){
		$.ajax(
			
				);
	}
</script>