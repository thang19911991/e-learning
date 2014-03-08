<script type="text/javascript">
	$(function(){
		if($(this).prop('checked')==true){
			$("#submit_button").attr("disabled",false);
		}else{
			$("#submit_button").attr("disabled",true);
		}
		
		$("#check").click(function(){
			if($(this).prop('checked')==true){
				$("#submit_button").attr("disabled",false);
			}else{
				$("#submit_button").attr("disabled",true);
			}
		});

		$("#submit_button").click(function(){
			$("#check").prop("checked",false);
		});
	});
</script>
<div class="users form">
<h2>先生の登録</h2>
<?php
	echo $this->Form->create('User',array('url' => array('controller' => 'teacher', 'action' => 'register'), 'type' => 'file'));
	echo $this->Form->input('username',array('required'=>'false','label' => 'ユーザー名'));
	echo $this->Form->input('password',array('required'=>'false','label' => 'パスワード'));
	echo $this->Form->input('re_password',array('required'=>'false','label' => '確認パスワード','type' => 'password'));
	echo $this->Form->input('full_name',array('required'=>'false','label' => '名前'));
	echo $this->Form->input('email',array('required'=>'false','label' => 'メール'));
	echo $this->Form->input('address',array('required'=>'false','label' => 'アドレス'));
	echo $this->Form->input('birthday', array(
										'dateFormat' => 'DMY',
										'timeFormat' => null,
										'minYear' => date('Y') - 70,
										'maxYear' => date('Y') - 0,'label' => '誕生日'));
	echo $this->Form->input('phone',array('label' => '電話番号','required' => 'false'));
	echo $this->Form->input('verify_code',array('label' => 'セキュリティー質問','required' => 'false'));
	echo $this->Form->input('verify_code_answer',array('label' => 'セキュリティー答え','required' => 'false'));
	echo $this->Form->input('profile_img',array('required'=>'false','type' => 'file','label' => 'アバター'));
	echo $this->Form->input('credit_number',array('label' => 'Credit Card','required'=>'false', 'maxlength' => '28', 'style' => 'width:392px'));
	echo $this->Form->input('information',array('label' => '自己PR','type' => 'textarea' ,'required'=>'false'));
	echo $this->Form->input('checkbox',array('label' =>'ウェブサイトの規則を賛成しますか？', 'type' => 'checkbox', 'id' => 'check'));
	echo $this->Form->button("Register", array('label' => false, 'type' => 'submit', 'id' => 'submit_button'));
	echo $this->Form->end();
?>
</div>
<div class="actions">
	<?php
		echo $this->Html->link("ログイン",array('controller'=> 'teacher', 'action' => 'login'));
	?>
</div>