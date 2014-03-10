<div class='users index'>
	<h2>User edit profile</h2>
	<?php
//		echo '<pre>';
//		var_dump($ad);
//		die();
		echo $this->Form->create('User');
		
		echo $this->Form->input('full_name');
		
		echo $this->Form->input('birthday', array( 'label' => 'Date of birth'
  							, 'type' => 'date'
                            , 'dateFormat' => 'DMY'
                            , 'minYear' => date('Y') - 120
                            , 'maxYear' => date('Y')));
		echo $this->Form->input('User.address');
		echo $this->Form->input('phone');
		echo $this->Form->input('credit_number');
		echo $this->Form->input('Ip.IP');
		
		echo '<p>' . 'IP list: ' . $ad['Ip']['IP'] . '</p>' ;

		echo $this->Form->button('Clear',array('type' => 'reset'));
		echo $this->Form->button('Cancel', array('name' => 'cancel','action'=>'view_profile'));
		echo $this->Form->end('Save',array('controller' => 'admins', 'action' => 'edit_profile'));
//		echo $this->Html->link('Change Password', array('action'=>'change_password'));
//		echo $this->Html->link('Change IP list', array('action'=>'change_ip'));
	?>
</div>

