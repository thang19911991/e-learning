<div>
<h1>禁止学生</h1>
</div>
<div class="error">
	<?php 
		echo $this->Session->Flash();
	?>
</div>

<div>
<table>
	<tr>
		<th>
			学生名
		</th>
		<th>
			禁止理由
		</th>
		<th> </th>
	</tr>
	<?php 
		foreach ($data as $ban){
			echo "<tr>";
			echo "<td>";
			echo $ban['Ban']['student_name'];
			echo "</td>";
			echo "<td>";
			echo $ban['Ban']['reason'];
			echo "</td>";
			echo "<td>";
			echo $this->Html->link( "Unban", array (
				'controller' => 'Teachers',
				'action' => 'unban',$ban['Ban']['id'] ));
			echo "</td>";
			echo "</tr>";
		}
	?>
</table>
</div>

<script type="text/javascript">
	function checkSave(){
		if($("#banStudent").val()==''){
			alert("学生のユーザ名が空き");
			return false;
		}

		if($("#banReason").val()==''){
			alert("理由が空き");
			return false;
		}
		return true;
	}
</script>