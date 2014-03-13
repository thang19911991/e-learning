<div class = 'user index'>
	<h2>Database Manager</h2>
	
	<table>
		<tr>
			<th>File name</th>
			<th>File size</th>		
			<th>Created date</th>
			<th>Restore</th>
			<th><?php echo $this->Html->link('Delete all',array('controller'=>'admins', 'action'=>'delete_all'),array(),"Are you sure to delete all backup files");?></th>
		</tr>
		
		<?php foreach ($files_info as $file_info) {
				echo "<tr>";
					echo "<td>".$file_info['basename']."</td>";
					$filesize = round($file_info['filesize']/1024,1);
					echo "<td>".$filesize." KB</td>";
					echo "<td>".$file_info['created_date']."</td>";
					//echo "<td>".$file_info['created_date']."</td>";
					//echo "<td>".$user['Course']['login_status']."</td>";
					//echo "<td>".$user['Course']['active_status']."</td>";
					//echo "<td>".$this->Html->link($course['Teacher']['name'],array('controller'=>'admins', 'action'=>'user_profile', 'id' => $course['Teacher']['user_id']))."</td>";
					echo "<td>".$this->Html->link('Restore',array('controller'=>'admins', 'action'=>'restore_database', 'file' => $file_info['basename']),array(),"Are you sure to delete this backup to replace current database")."</td>";
					echo "<td>".$this->Html->link('Delete',array('controller'=>'admins', 'action'=>'delete_file', 'file' => $file_info['basename']),array(),"Are you sure to delete this backup")."</td>";
				echo "</tr>";			
		}?>
	</table>
	<?php echo "<td>".$this->Html->link('Create a backup',array('controller'=>'admins', 'action'=>'backup_database'),array(),"Are you sure to create a backup")."</td>"; ?>
	
</div>

