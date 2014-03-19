<?php
//	echo '<pre>';
//	var_dump($teacher_name) ;
?>
<div class='users index'>
	<h2>Monthly Payment of System</h2>
	<table>
		<tr>
			<th>ID</th>
			<th>Student</th>
			<th>Course</th>
			<th>Teacher</th>
			<th>Buy date</th>
		</tr>
		<?php 
			$i = 0;
			foreach ($payments as $payment):
		?>
		<tr>
			<td><?php echo $i + 1 ?></td>
			<td><?php echo $this->Html->link($students[$i]['User']['username'],
						array('controller' => 'admins', 'action' => 'user_profile', 'id' => $students[$i]['User']['id']));
					
				?>
			</td>
			<td><?php echo $this->Html->link($payment['Course']['course_name'],
						array('controller' => 'admins', 'action' => 'view_course',$payment['Course']['id']));
				?>
			</td>
			<td><?php echo $this->Html->link($teachers[$i]['User']['username'],
						array('controller' => 'admins', 'action' => 'user_profile','id' => $teachers[$i]['User']['id']));
					$i ++;
				?>
			</td>
			<td><?php echo $payment['StudentCourseLearn']['buy_date']; ?></td>
		</tr>
		<?php endforeach; ?>
		<tr><?php
			if($create_payment == true){
				echo '<td colspan="3">'."Number of bought course: " . count($payment);
				echo "<br>Total: " . count($payment) * $KOMA_COST . '</td><td colspan="2">';
				echo $this->Html->Link('Acept and create payment last month', array('action' => 'create_payment', $year, $month));
				echo "<br>" . "If there are any error, let contact to E-learning office!</td>";
			}
			else echo '<td colspan="5">You can view only</td>' ;
		?></tr>
	</table>
</div>
