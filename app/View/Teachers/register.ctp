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

<div class="row">
    <?php echo $this->Session->flash(); ?>
    <div class="col-md-8 col-md-offset-2">			

<?php echo $this->Form->create('User',array(
				'url' => array('controller' => 'teachers', 'action' => 'register'),
				'type' => 'file',
				'class' => 'well',
				'inputDefaults' => array(
					'class' => 'form-control',
					'div' => false,
					'label' => false
				)
	)); ?>
	
	<div class="form-group">
		<?php echo $this->Form->input('username',array(
			'class' => 'form-control',
			'required'=>'false',
			'label' => 'ユーザー名')); ?>
	</div>
	
	<div class="form-group">
		<?php echo $this->Form->input('password',array(
			'required'=>'false',
			'label' => 'パスワード')); ?>
	</div>
	
	<div class="form-group">
		<?php echo $this->Form->input('re_password',array(
			'required'=>'false',
			'label' => '確認パスワード',
			'type' => 'password')); ?>
	</div>
	
	<div class="form-group">
		<?php echo $this->Form->input('full_name',array(
			'required'=>'false',
			'label' => '名前')); ?>
	</div>
	
	<div class="form-group">
		<?php echo $this->Form->input('email',array(
			'required'=>'false',
			'label' => 'メール')); ?> 
	</div>
	
	<div class="form-group">
		<?php echo $this->Form->input('address',array(
			'required'=>'false',
			'label' => 'アドレス')); ?>
	</div>
	
	<div class="form-group">
	<?php echo $this->Form->input('birthday', array(
										'dateFormat' => 'DMY',
										'timeFormat' => null,
										'minYear' => date('Y') - 70,
										'maxYear' => date('Y') - 0,'label' => '誕生日')); ?>
	</div>
	
	<div class="form-group">
		<?php echo $this->Form->input('phone',array(		
			'label' => '電話番号',
			'required' => 'false')); ?>
	</div>
	
	<div class="form-group">
		<?php echo $this->Form->input('verify_code',array(
			'label' => 'セキュリティー質問',
			'required' => 'false')); ?>
	</div>
	
	<div class="form-group">
		<?php echo $this->Form->input('verify_code_answer',array(
			'label' => 'セキュリティー答え',
			'required' => 'false')); ?>
	</div>
	
	<div class="form-group">
		<?php echo $this->Form->input('profile_img',array(
			'required'=>'false',
			'type' => 'file',
			'label' => 'アバター')); ?>
	</div>
	
	<div class="form-group">
		<?php echo $this->Form->input('credit_number',array(
			'label' => 'Credit Card',
			'required'=>'false', 
			'maxlength' => '28', 
			'style' => 'width:392px')); ?>
	</div>
	
	<div class="form-group">
		<?php echo $this->Form->input('information',array(
			'label' => '自己PR',
			'type' => 'textarea' ,
			'required'=>'false')); ?>
	</div>
	
	<div class="checkbox">
		<?php echo $this->Form->input('checkbox',array(
			'class' => false,
			'label' =>'ウェブサイトの規則を賛成しますか？',
			'type' => 'checkbox',
			'id' => 'check')); ?>
	</div>
	
	<div class="form-group">
		<?php echo $this->Form->button("登録", array(
			'class' => 'btn btn-primary',
			'label' => false, 
			'type' => 'submit', 
			'id' => 'submit_button'));?>
	</div>
	<?php echo $this->Form->end(); ?>
</div>
</div>

