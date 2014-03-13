<div class="users index">
	<h2>Admin change IP</h2>
	<?php
//		echo '<pre>';
//		debug($admin);
//		die();
		echo $this->Form->create('Ip');
		echo '<p>' . 'User name: ' . $admin['User']['username'] . '</p>';
		echo '<p>' . 'Full name: ' . $admin['User']['full_name'] . '</p>';
		if(isset($option) && $option == true){
			echo '<p>' . 'Current admin login IP: ' . $current_admin_login_ip . '</p>';
		} else{
			$option = false;
		}
		echo '<p>' . 'Admin IP list: ' . $admin['Ip']['IP'] . '</p>';
		
		echo $this->Form->input("id", array('value' => $admin['Ip']['id'], 'type' => 'hidden'));
		echo $this->Form->input("IP", array('value' => $admin['Ip']['IP'],'label' => 'Enter new IP list, split by ;'));
		echo $this->Form->input('admin_id', array('value'=>$admin['User']['id'],'type' => 'hidden'));
		echo $this->Html->link('Cancel', array('action'=>'view_profile'));
		echo $this->Form->end('Save',array('controller' => 'admins', 'action' => 'change_ip'));
		
	?>
</div>


