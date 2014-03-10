

<div class='users index'>
<?php if($is_valid_user) {?>
	<h2>User edit profile</h2>
	<?php
//		echo '<pre>';
//		var_dump($user);
//		die();

//	
 		echo $this->Form->create('User',array('url'=>$this->Html->url(array('controller'=>'admins', 'action'=>'edit_user_profile')))) ;
		echo '<h4>' . 'User name: ' . $user['User']['username'] . '</h4>';
		echo $this->Form->input('id',  array('value' => $user['User']['id'], 'visibility' => 'hidden'));
		echo $this->Form->input('full_name',  array('value' => $user['User']['full_name']));		
		echo $this->Form->input('email', array('type' => 'email', 'value' => $user['User']['email']));
		
		echo $this->Form->input('birthday', array( 'label' => 'Date of birth'
  							, 'type' => 'date'
                            , 'dateFormat' => 'DMY'
                            , 'minYear' => date('Y') - 120
                            , 'maxYear' => date('Y')
                            , 'selected' => $user['User']['birthday']));
		echo $this->Form->input('address',array('value' => $user['User']['address']));
		echo $this->Form->input('phone', array('value' => $user['User']['phone']));
		echo $this->Form->input('credit_number', array('value' => $user['User']['credit_number']));
			
	

	
		//echo $this->Form->input('IP list', array('placeholder' => $ad['Ip']['IP']));
		//echo '<p>' . 'IP list: ' . $ad['Ip']['IP'] . '</p>' ;
//		echo $this->Form->input('Old password', array('placeholder' => 'Enter your old password','type'=>'password'));
//		echo $this->Form->input('New password', array('placeholder' => 'Enter new password','type'=>'password'));
//		echo $this->Form->input('Confirm new password', array('placeholder' => 'Reenter new password', 'type'=>'password'));

		//echo $this->Form->button('Clear',array('type' => 'reset'));
		echo $this->Html->link('Cancel', array('action'=>'user_profile', 'id' => $user['User']['id']));
		echo $this->Form->end('Save',array('controller' => 'admins', 'action' => 'edit_user_profile'));
//		echo $this->Html->link('Change Password', array('action'=>'change_password'));
//		echo $this->Html->link('Change IP list', array('action'=>'change_ip'));
	?>
	<?php } else {
echo '<h2>Invalid User</h2>';
}?>
</div>



