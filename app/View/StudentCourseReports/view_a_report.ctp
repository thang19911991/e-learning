<?php
//	echo '<pre>';
//	var_dump($teacher_name) ;
?>
<div class='users index'>
	<h2>View course copyright report</h2>
	<table>
		<tr>
			<th>Report ID</th>
			<th>Student</th>
			<th>Teacher</th>
			<th>Course</th>
			<th>Content</th>
		</tr>
		<tr>
			<td><?php echo $report['StudentCourseReport']['id']; ?></td>
			<td><?php echo $this->Html->link($student['User']['username'],
						array('controller' => 'admins', 'action' => 'user_profile', 'id' => $student['User']['id']));
					echo '<br>';
					echo "Contact student:<br>Phone: \t" . $student['User']['phone'];
				?>
			</td>
			<td><?php
					echo $this->Html->link($teacher['User']['username'],
						array('controller' => 'admins', 'action' => 'user_profile', 'id' => $teacher['User']['id']));
					echo '<br>';
					echo "Contact teacher:<br>Phone: \t" . $teacher['User']['phone'];
				?>
			</td>
			<td><?php echo $this->Html->link($report['Course']['course_name'],
						array('controller' => 'admins', 'action' => 'view_course',$report['Course']['id']));
					echo '<br>Created date: ' . $report['Course']['created_date'];
					echo '<br>Number of copyright report: ' . $course_number_report;
				?>
			</td>
			<td><?php echo $report['StudentCourseReport']['content']; ?></td>
		</tr>
		
	</table>
</div>
