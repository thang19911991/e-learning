<div class="users index">
<h2>アカウントを脱退</h2>
<div>
<?php
echo $this->Session->Flash();
?>
</div>
<?php 
	echo $this->Form->create('User',array('type' => 'post'));
	echo $this->Form->input('password',array('required'=>'false','label' => 'パスワード','type' => 'password'));
	echo $this->Form->input('re_password',array('required'=>'false','label' => 'レーパスワード','type' => 'password'));
	echo $this->Form->end('Confirm', array('controller' => 'student', 'action' => 'std_deactive'));
?>
</div>
