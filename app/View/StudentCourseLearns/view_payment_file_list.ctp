<div class='users index'>
	<h2>System payment file list</h2>
	<table>
		<tr>
			<th>Number</th>
			<th>File name</th>
			<th>Create Date</th>
			<th>Size (bytes)</th>
			<th>Download</th>
		</tr>
		<?php
			
			if(isset($message)) echo '<tr><td colspan="5">'.$message.'</td></tr>';
			if(!isset($files) || count($files) == 0) echo '<tr><td colspan="5">No payment file</td></tr>';
			else{
				$i = 0;
				foreach ($files as $file){
					echo '<tr>';
					echo '<td>' . ++$i . '</td>';
					echo '<td>' . $file->name() . '.' . $file->ext(). '</td>';
					echo '<td>' . date ('Y-m-d H:i:s', $file->lastAccess()) . '</td>';
					echo '<td>' . $file->size() . '</td>';
					echo '<td>' . $this->Html->link('Download', array('action'=>'download_payment_file',$file->ext(), $file->name())) . '</td>';
//					echo '<td>' . '</td>';
			 		echo '</tr>';
//			 		$this->response->file('index.php');
//			 		debug($file->name());
			 	}
			}
		?>
	</table>
</div>