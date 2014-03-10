
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
//  padding: 5px 15px;
//    background: #4479BA;
//    color: #FFF;	
}
.attr {
	width: 300;
}

table,th,td
{
	//colspan: 2;
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
		<th>Course Id</th>
		<th><?php echo $course['Course']['id']?></th>		
	</tr>
	
	<tr>
		<th>Course name</th>
		<th><?php echo $course['Course']['course_name']?></th>		
	</tr>
	
	<tr>
		<th>Teacher Username</th>
		<th><?php echo $this->Html->link($course['User']['username'],array('controller' => 'admins', 'action' =>'user_profile', 'id' => $course['User']['id']),array())?></th>		
	</tr>
	<tr>
		<th>Teacher full name</th>
		<th><?php echo $course['User']['full_name']?></th>		
	</tr>
	<tr>
		<th>Description</th>
		<th><?php echo $course['Course']['description']?></th>		
	</tr>
	<tr>
		<th>Date created</th>
		<th><?php echo $course['Course']['created_date']?></th>		
	</tr>
	
	<tr>
		<th>Documents</th>
		<th>
			<?php
			
			foreach ($course['Document'] as $doc){
				echo $this->Html->link("- ".$doc['name'], array('controller' => 'admins', 'action' => 'document_detail', 'id' => $doc['id']));
			}
			?>
		</th>		
	</tr>	
	
	
	<tr>
		<td colspan= "2" >
			<ul class = 'action'>
				
				<?php 
				if($course['Course']['status'] == 'inactive') 
					echo "<li>". $this->Html->link( "Active", array('action'=>'active_course', 'controller' => 'admins','id' => $course['Course']['id']),array(),"Are you sure to active this course")."</li>" ;
				else echo "<li>". $this->Html->link( "Deactive", array('action'=>'deactive_course', 'controller' => 'admins','id' => $course['Course']['id']),array(),"Are you sure to deactive this course")."</li>";
					?>
 
				<li><?php echo $this->Html->link("Delete", array('action'=>'delete_course', 'controller' => 'admins','id' => $course['Course']['id']),array(),"Are you sure to delete this course"); ?></li>
				
			</ul>
		</td>
		
	</tr>
	
	
	
</table>
</div>




