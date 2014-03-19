<div class="row">
    <?php echo $this->Session->flash(); ?>
    <div class="col-md-8 col-md-offset-2">
		
	<?php echo $this->Form->create('User', array(
    'inputDefaults' => array(
        'div' => false,
        'label' => false,
        'wrapInput' => false,
        'class' => 'form-control'
    ),
    'class' => 'well'
	)); ?>

    <div class="form-group">
	<?php echo $this->Form->input('username', array(  
	    'placeholder' => 'Username',
	    'style' => 'width:180px;',
	    'label' => 'ユーザー名',
		'required' => false
	)); ?>
    </div>
    <div class="form-group">
	<?php echo $this->Form->input('password', array(  
	    'placeholder' => 'Password',
	    'style' => 'width:180px;',
	    'label' => 'パスワード',
		'required' => false
	)); ?>  
    </div>
	<?php echo $this->Form->submit('ログイン', array(  
	    'div' => false,  
	    'class' => 'btn btn-primary'  
	)); ?>
    <?php echo $this->Form->end(); ?>
    </div>  
</div>