<?php
//	echo '<pre>';
//	var_dump($report) ;
?>
<div class='users index'>
	<h2>View course copyright report</h2>
	<table>
		<tr>
			<th>Report ID</th>
			<th>Student</th>
			<th>Teacher</th>
			<th>Document</th>
			<th>Course</th>
			<th>Content</th>
		</tr>
		<tr>
			<td><?php echo $report['StudentDocumentReport']['id']; ?></td>
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
			<td><?php echo $this->Html->link($report['Document']['name'],
						array('controller' => 'admins', 'action' => 'view_document',$report['Document']['id']));
					echo '<br>Created date: ' . $report['Document']['upload_date'];
					echo '<br>Number of copyright report: ' . $document_number_report;
				?>
			</td>
			<td><?php echo $this->Html->link($course['Course']['course_name'],
						array('controller' => 'admins', 'action' => 'view_course',$course['Course']['id']));
				?>
			</td>
			<td><?php echo $report['StudentDocumentReport']['content']; ?></td>
		</tr>
		
	</table>
</div>
