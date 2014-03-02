<div class="users form">
<h2>Add a New User</h2>
<?php
	echo $this->Form->create('User',array('type' => 'post'));
	
	// NOTE : field username, password, birthday, fullname ... là các field trong bang member
	// nếu mà không trùng tên thì sẽ không cho vào trong bảng member được, nếu muốn 
	// insert vào trong bảng member thì trong MembersController ta phải chỉnh sửa -> mất thời gian
	// do đó mà các input ở dưới cần khai báo trùng tên với tên filed trong bảng members
	echo $this->Form->input('username',array('required'=>'false','label' => 'ユーザー名'));
	echo $this->Form->input('password',array('required'=>'false','label' => 'パスワード'));
	echo $this->Form->input('repassword',array('required'=>'false','label' => 'レーパスワード','type' => 'password'));
	echo $this->Form->input('full_name',array('required'=>'false','label' => '名前'));
	echo $this->Form->input('address',array('required'=>'false','label' => 'メールアドレス'));
	echo $this->Form->input('birthday', array(
										'dateFormat' => 'DMY',
										'timeFormat' => null,
										'minYear' => date('Y') - 70,
										'maxYear' => date('Y') - 0,'label' => '誕生日'));
	echo $this->Form->input('phone',array('label' => '電話番号'));
	//echo $this->Form->input('verifycode_id',array('label' => 'セキュリティー質問'));
	//echo $this->Form->input('verifycode_answer',array('label' => 'セキュリティー答え'));
	//echo $this->Form->input('avatar',array('required'=>'false','type' => 'file','label' => 'アバター'));
	echo $this->Form->input('creditnumber',array('label' => 'Credit Card','required'=>'false'));
	//echo $this->Form->input('information',array('label' => '自己PR','type' => 'textarea' ,'required'=>'false'));
	echo $this->Form->input('checkbox',array('label' =>'ウェブサイトの規則を賛成しますか？', 'type' => 'checkbox'));
	echo $this->Form->end('Register', array('controller' => 'teacher', 'action' => 'login'));
?>
</div>

<div class="actions">
	<?php
		echo $this->Html->link("Login",array('controller'=> 'teacher', 'action' => 'login'));
	?>
</div>