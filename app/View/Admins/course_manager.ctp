
<div class="users index">
<h2>Users</h2>
<table>
	<tr>
		<th><?php echo $this->Paginator->sort("id")?></th>
		<th><?php echo $this->Paginator->sort("course_name")?></th>		
		<th><?php echo $this->Paginator->sort('Teacher.name', 'Teacher Name')?></th>
		<th><?php echo $this->Paginator->sort('status', 'Status')?></th>
		<th>Action</th>
	</tr>
	<?php 
		foreach ($courses as $course) {			
			echo "<tr>";
				echo "<td>".$course['Course']['id']."</td>";
				echo "<td>".$course['Course']['course_name']."</td>";
				echo "<td>".$course['Teacher']['name']."</td>";
				echo "<td>".$course['Course']['status']."</td>";
				//echo "<td>".$user['Course']['login_status']."</td>";
				//echo "<td>".$user['Course']['active_status']."</td>";
				//echo "<td>".$this->Html->link($course['Teacher']['name'],array('controller'=>'admins', 'action'=>'user_profile', 'id' => $course['Teacher']['user_id']))."</td>";
				echo "<td>".$this->Html->link('Manage',array('controller'=>'admins', 'action'=>'course_detail', 'id' => $course['Course']['id']))."</td>";
			echo "</tr>";			
		}
	?>
</table>

<?php echo $this->Paginator->counter(
    'Page {:page} of {:pages}, showing {:current} records out of
     {:count} total, starting on record {:start}, ending on {:end}'
); ?>

<div class="paging">	
	<?php echo $this->Paginator->first(); ?>
	<?php echo $this->Paginator->prev(); ?>
	<?php echo $this->Paginator->numbers(); ?>
	<?php echo $this->Paginator->next(); ?>
	<?php echo $this->Paginator->last(); ?>
</div>
</div>



