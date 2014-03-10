<div class="users form">
<h2>プロフィール変更</h2>
<?php 
// var_dump($user);
	echo $this->Form->create('User',array('type' => 'file'));		
	echo $this->Form->input('full_name',array('required'=>'false','label' => '名前', 'value' => $user['User']['full_name']));
	echo $this->Form->input('birthday', array(
			'dateFormat' => 'DMY',
			'minYear' => date('Y') - 70,
			'maxYear' => date('Y') - 0,'label' => '誕生日','type' => 'date','selected' => $user['User']['birthday']));
	echo $this->Form->input('email',array('required'=>'false','label' => 'メールアドレス','value' => $user['User']['email']));
	echo $this->Form->input('credit_number',array('required'=>'false','label' => 'Credit Card','value' => $user['User']['credit_number']));
	echo $this->Form->input('phone',array('label' => '電話番号','value'=>$user['User']['phone'], 'required'=>'false'));
	echo $this->Form->input('address',array('label' => '住所','value'=>$user['User']['address'], 'required'=>'false'));
	echo $this->Form->input('profile_img',array('required'=>'false','type' => 'file','label' => 'アバター'));
	//echo $this->Form->input('information',array('required'=>'false', 'label' => '自己PR','type' => 'textarea' ,'required'=>'false','value' => $user['students']['additional_info']));
	echo $this->Form->end('Confirm', array('controller' => 'student', 'action' => 'std_edit'));
?>
</div>