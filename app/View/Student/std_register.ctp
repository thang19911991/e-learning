<script>
    var checkEmail =0;
    var checkUsername =0;
</script>	
<?php
echo $this->Form->create('User', array('autoComplete' => 'off','enctype' => 'multipart/form-data','inputDefaults' => array('label' => false , 'div' => false, )));
?>
<?php 
  echo $this->Form->input('full_name', array(
                    					'type' => 'text',
  			                            'label' => '名前',
                   						'required' => false));

  ?> <?php
  echo $this->Form->input('birthday', array(
                    					'type' => 'date',
										'dateFormat' => 'DMY',
										'timeFormat' => null,
										'minYear' => date('Y') - 70,
                   						'label' => '誕生日',
										'maxYear' => date('Y') - 0));
  ?>
  <?php 
  echo $this->Form->input('username', array(
                    					'type' => 'text',
  			                            'label' => 'ユーザ名',
                   						'required' => false));

  ?>
  <?php 
  echo $this->Form->input('password', array(
                    					'type' => 'password',
  			                            'label' => 'パスワード',
                   						'required' => false));

  ?>
  <?php 
  echo $this->Form->input('repassword', array(
                    					'type' => 'password',
  			                            'label' => '確認パスワード',
                   						'required' => false));
  ?>
  <?php 
  echo $this->Form->input('primary_password', array(
                    					'type' => 'text',
  			                            'label' => '初期パスワード',
                   						'required' => false));
  ?>
  <?php 
  echo $this->Form->input('email', array(
                    					'type' => 'text',
  			                            'label' => 'メール',
                   						'required' => false));
  ?>
  <?php 
  echo $this->Form->input('address', array(
                    					'type' => 'text',
  			                            'label' => 'アドレス',
                   						'required' => false));
  ?>
  <?php 
  echo $this->Form->input('phone', array(
                    					'type' => 'text',
  			                            'label' => '電話番号',
                   						'required' => false));
  ?>
  <?php 
  echo $this->Form->input('credit_number', array(
                    					'type' => 'text',
  			                            'label' => 'クレジットカード',
                   						'required' => false));
  ?>
  <?php 
  echo $this->Form->input('profile_img', array(
                    					'type' => 'file',
  			                            'label' => 'アバター',
                   						'required' => false));
  ?>
  <?php
  echo $this->Form->submit('Submit');
  echo $this->Form->end();?>