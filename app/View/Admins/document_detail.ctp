
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
	
	border:1px solid gray;
	border-collapse:collapse
}
</style>



<div class="users index">

	<table>
	<col width="200">
  	<col width="400">
	<tr class ='title'>
		<th class = 'attr'>Attribute</th>
		<th>Value</th>		
	</tr>	
	
	<tr>
		<th>Document ID</th>
		<th><?php echo $doc['Document']['id']?></th>		
	</tr>
	
	<tr>
		<th>Document name</th>
		<th><?php echo $doc['Document']['name']?></th>		
	</tr>
	<tr>
		<th>Document Type</th>
		<th><?php echo $doc['Document']['type']?></th>		
	</tr>
	
	<tr>
		<th>Course name</th>
		<th><?php echo $this->Html->link($doc['Course']['course_name'],array('controller' => 'admins', 'action' =>'course_detail', 'id' => $doc['Course']['id']),array())?></th>		
	</tr>
	
	<tr>
		<th>Teacher Username</th>
		<th><?php echo $this->Html->link($doc['User']['username'],array('controller' => 'admins', 'action' =>'user_profile', 'id' => $doc['User']['id']),array())?></th>		
	</tr>
	<tr>
		<th>Teacher full name</th>
		<th><?php echo $doc['User']['full_name']?></th>		
	</tr>
	
	
	
	<tr>
		<td colspan= "2" >
			<ul class = 'action'>
				
				<?php 
				
				if($doc['Document']['status'] == 'inactive') 
					echo "<li>". $this->Html->link( "Active", array('action'=>'active_document', 'controller' => 'admins','id' => $doc['Document']['id']),array(),"Are you sure to active this document")."</li>" ;
				else echo "<li>". $this->Html->link( "Deactive", array('action'=>'deactive_document', 'controller' => 'admins','id' => $doc['Document']['id']),array(),"Are you sure to deactive this document")."</li>";
					?>
 
				<li><?php echo $this->Html->link("Delete", array('action'=>'delete_document', 'controller' => 'admins','id' => $doc['Document']['id']),array(),"Are you sure to delete this document"); ?></li>
				
			</ul>
		</td>
		
	</tr>
	
	
	
</table>
</div>




