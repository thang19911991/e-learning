<div>
<h1>学生のテスト結果</h1>
</div>
<div>
<table>
<tr>
	<th>
		学生名
	</th>
	<th>
		テスト名
	</th>
	<th>
		点
	</th>
	<th>
		テスト日
	</th>
</tr>
<?php 
	foreach ($data as $test){
		for($i=0;$i<count($test);$i++){
		?>
<tr>
	<td>
		<?php 
			echo $test[$i]['student_name']['User']['username'];
		?>
	</td>
	<td>
		<?php 
			echo $test[$i]['test_name'];
		?>
	</td>
	<td>
		<?php 
			echo $test[$i]['students_tests']['point'];
		?>
	</td>
	<td>
		<?php 
			echo $test[$i]['students_tests']['test_date'];
		?>
	</td>
</tr>
<?php 		
		}
	}
?>
</table>
</div>