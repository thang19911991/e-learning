<?php
//	echo '<pre>';
//	var_dump($course_name) ;
?>
<div class='users index'>
	<h2>List document copyright report</h2>
	<table>
		<tr>
			<th>Report ID</th>
			<th>Student</th>
			<th>Course</th>
			<th>Document name</th>
			<th>Report Content</th>
			<th>Action</th>
		</tr>
		<?php 
			$i = 0;
			foreach ($reports as $report):
		?>
		<tr>
			<td><?php echo $report['StudentDocumentReport']['id']; ?></td>
			<td><?php echo $this->Html->link($students[$i]['User']['username'],
						array('controller' => 'admins', 'action' => 'user_profile', 'id' => $students[$i]['User']['id'])); ?>
			</td>
			<td><?php
					echo $this->Html->link($courses[$i]['Course']['course_name'],
						array('controller' => 'admins', 'action' => 'view_course', $report['Document']['course_id']));
					$i ++;
				?>
			</td>
			<td><?php echo $this->Html->link($report['Document']['name'],
						array('controller' => 'admins', 'action' => 'view_document',$report['StudentDocumentReport']['document_id'])); ?>
			</td>
			<td><?php echo $report['StudentDocumentReport']['content']; ?></td>
			<td><?php echo $this->Html->link('View Detail', array('action' => 'view_a_report', $report['StudentDocumentReport']['id'])); ?></td>
		</tr>
		
		<?php endforeach; ?>
	</table>
</div>
