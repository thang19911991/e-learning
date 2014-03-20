<script>
    var checkEmail =0;
    var checkUsername =0;
</script>
<div class="row">
    <?php echo $this->Session->flash(); ?>
    <div class="col-md-6 col-md-offset-3">

	<?php echo $this->Form->create('User', array(	
										'autoComplete' => 'off',
										'class' => 'well',
										'enctype' => 'multipart/form-data',
										'inputDefaults' => array(
											'label' => false ,
											'div' => false,
											'wrapInput' => false,
											'class' => 'form-control'
										))
	);?>
	
	<div class="form-group">
	<?php echo $this->Form->input('full_name', array(
                    					'type' => 'text',
  			                            'label' => '名前',
                   						'required' => false));?>
	</div>
	
	<div class="form-group">
   	<?php echo $this->Form->input('birthday', array(
                    					'type' => 'date',
										'dateFormat' => 'DMY',
										'timeFormat' => null,
										'minYear' => date('Y') - 70,
                   						'label' => '誕生日',
										'maxYear' => date('Y') - 0)); ?>
	</div>
  	<div class="form-group">
  	<?php echo $this->Form->input('username', array(
                    					'type' => 'text',
  			                            'label' => 'ユーザ名',
  										'style' => 'width:180px;',
                   						'required' => false)); ?>
  	</div>
  	
  	<div class="form-group">
  	<?php echo $this->Form->input('password', array(
                    					'type' => 'password',
  			                            'label' => 'パスワード',
                   						'required' => false)); ?>
	</div>                   						
	
	<div class="form-group">
  	<?php  echo $this->Form->input('repassword', array(
                    					'type' => 'password',
  			                            'label' => '確認パスワード',
                   						'required' => false)); ?>
	</div>
	
	<div class="form-group">                   						
  	<?php echo $this->Form->input('primary_password', array(
                    					'type' => 'text',
  			                            'label' => '初期パスワード',
                   						'required' => false)); ?>
	</div>
	
	<div class="form-group">
  	<?php echo $this->Form->input('email', array(
                    					'type' => 'text',
  			                            'label' => 'メール',
                   						'required' => false)); ?>
	</div>
	
	<div class="form-group">
	<?php echo $this->Form->input('address', array(
                    					'type' => 'text',
  			                            'label' => 'アドレス',
                   						'required' => false)); ?>
	</div>
	
	<div class="form-group">
  	<?php echo $this->Form->input('phone', array(
                    					'type' => 'text',
  			                            'label' => '電話番号',
                   						'required' => false)); ?>
	</div>
	
	<div class="form-group">
  	<?php echo $this->Form->input('credit_number', array(
                    					'type' => 'text',
  			                            'label' => 'クレジットカード',
                   						'required' => false)); ?>
	</div>
	
	<div class="form-group">
  	<?php echo $this->Form->input('profile_img', array(
                    					'type' => 'file',
  			                            'label' => 'アバター',
                   						'required' => false)); ?>
  
    </div>    
        
	<?php echo $this->Form->submit('登録', array(  
	    'div' => false,  
	    'class' => 'btn btn-primary'  
	)); ?>
    <?php echo $this->Form->end(); ?>
    </div>
</div>