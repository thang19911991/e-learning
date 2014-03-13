<div class="users index">
<?php
  echo $this->Form->create('Admin',  array('url'=>$this->Html->url(array('controller'=>'admins', 'action'=>'create_admin'))));
  echo $this->Form->input('User.username');
  echo $this->Form->input('User.password', array('type' => 'password'));

  echo $this->Form->input('User.full_name', array('label' => 'Full Name'));
 // echo $this->Form->input('Admin.verify_code_id', array('label' => 'Verify code id', 'type' => 'text'));
  echo $this->Form->input('User.email', array('label' => 'Email', 'type' => 'text'));
  echo $this->Form->input('User.address', array('label' => 'Address', 'type' => 'text'));
  echo $this->Form->input('User.credit_number', array('label' => 'Credit Number', 'type' => 'text'));
  echo $this->Form->input('User.phone', array('label' => 'Phone Number', 'type' => 'text'));

  echo $this->Form->input('User.birthday', array( 'label' => 'Date of birth'
  							, 'type' => 'date'
                            , 'dateFormat' => 'DMY'
                            , 'minYear' => date('Y') - 120
                            , 'maxYear' => date('Y')));  	
  
  echo $this->Form->input('Ip.IP', array('label' => 'IP Address', 'type' => 'text'));
  //echo $this->Form->input('credit_number',array('label' => 'Credit Number'));
  //echo $this->Form->input('email',array('label' => 'Email'));
  //echo $this->Form->input('primary_password',array('label' => 'Primary Password'));
  //echo $this->Form->input('birthday',array('label' => 'Birthday','type' => 'date'));
  
  //echo $this->Form->input('IP');  
  //echo $form->submit();
  echo $this->Form->end('create', array('controller' => 'admins','action'=>'create_admin'));
?>
</div>


