
<div class="users index">
<h2>Users</h2>
<table>
	<tr>
		<th><?php echo $this->Paginator->sort("id")?></th>
		<th><?php echo $this->Paginator->sort("username")?></th>
		<th><?php echo $this->Paginator->sort("role")?></th>

		<th><?php echo $this->Paginator->sort("login_status")?></th>
		<th><?php echo $this->Paginator->sort("active_status")?></th>
		<th>Action</th>
	</tr>
	<?php 
		foreach ($users as $user) {			
			echo "<tr>";
				echo "<td>".$user['User']['id']."</td>";
				echo "<td>".$user['User']['username']."</td>";
				echo "<td>".$user['User']['role']."</td>";

				echo "<td>".$user['User']['login_status']."</td>";
				echo "<td>".$user['User']['active_status']."</td>";
				echo "<td><a href = '".$this->Html->url(array('controller'=>'admins', 'action'=>'user_profile', 'id' => $user['User']['id']))."'>Manage</a></td>";
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
