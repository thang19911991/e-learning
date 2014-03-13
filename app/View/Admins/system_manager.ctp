

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

}
.attr {
	width: 300;
}

table,th,td
{
	
	border:1px solid white;
	border-collapse:collapse
}
</style>



<div class="users index">

	<table>
	<tr>
		
		<td colspan= "2"  class = 'attr title'>System Parameters	</td>
		
		
	</tr>	
	<col width="200">
  	<col width="400">
	
	<?php foreach ($system as $coup){
		echo "<tr>";
			echo "<th>".$coup['SystemParam']['name']."</th>";
			echo "<th>".$coup['SystemParam']['value']."</th>";	
		echo "</tr>";
		//debug($coup);
	}?>
	<tr>
		<td colspan= "2" >
			<ul class = 'action'>				
 
				<li><?php echo $this->Html->link("Edit", array('action'=>'edit_system', 'controller' => 'admins')); ?></li>
				
			</ul>
		</td>
		
	</tr>	
</table>
</div>




