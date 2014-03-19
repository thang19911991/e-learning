<?php
//	echo '<pre>';
//	var_dump($teacher_name) ;
?>
<div class='users index'>
	<h2>List course copyright report</h2>
	<table>
		<tr>
			<th>Report ID</th>
			<th>Student</th>
			<th>Teacher</th>
			<th>Course</th>
			<th>Content</th>
			<th>Action</th>
		</tr>
		<?php 
			$i = 0;
			foreach ($reports as $report):
		?>
		<tr>
			<td><?php echo $report['StudentCourseReport']['id']; ?></td>
			<td><?php 
					if($students[$i] != null){
						echo $this->Html->link($students[$i]['User']['username'],
							array('controller' => 'admins', 'action' => 'user_profile', 'id' => $students[$i]['User']['id']));
					}
					else{
						echo "Error database";
					}
						 ?>
			</td>
			<td><?php
					if($teachers[$i] != null){
						echo $this->Html->link($teachers[$i]['User']['username'],
							array('controller' => 'admins', 'action' => 'user_profile', 'id' => $teachers[$i]['User']['id']));
					}
					else{
						echo "Error database";
					}
					$i ++;
				?>
			</td>
			<td><?php
					if($report != null){
						echo $this->Html->link($report['Course']['course_name'],
						array('controller' => 'admins', 'action' => 'view_course',$report['Course']['id']));
					}
					else{
						echo "Error database";
					}
				?>
			</td>
			<td><?php echo $report['StudentCourseReport']['content']; ?></td>
			<td><?php echo $this->Html->link('View Detail', array('action' => 'view_a_report', $report['StudentCourseReport']['id'])); ?></td>
		</tr>
		
		<?php endforeach; ?>
		<?php //unset($post); ?>
	</table>
</div>
