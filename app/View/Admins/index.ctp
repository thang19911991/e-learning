

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
		
		<td colspan= "2"  class = 'attr title'>System Information	</td>
		
		
	</tr>	
	<col width="200">
  	<col width="400">
	
	
	<tr>
		<th>All members</th>
		<th><?php echo sizeof($user)." members"?></th>		
	</tr>
	
	<tr>
		<th>Online member</th>
		<th><?php echo sizeof($online_user)." members"?></th>		
	</tr>
	<tr>
		<th>Inactive member</th>
		<th><?php echo sizeof($inactive_user)." members"?></th>
	</tr>
	
	<tr>
		<th>All courses</th>
		<th><?php echo sizeof($course)." courses"?></th>		
	</tr>
	
	<tr>
		<th>Inactive courses</th>
		<th><?php echo sizeof($inactive_course)." courses"?></th>		
	</tr>
	
	
	
	
	
	
	
</table>
</div>




