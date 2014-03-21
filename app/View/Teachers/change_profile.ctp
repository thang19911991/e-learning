<style>
.main {
	margin-top: 50px;
}
</style>
<div class="col-sm-6 col-sm-offset-5 col-md-6 col-md-offset-2 main">
	<div class="row">
		<?php //echo $this->Session->flash(); ?>
		<span class="label label-danger" style="font-size: 21px;" >プロファイル変化</span>
		<?php echo $this->Form->create('User',array(
			'inputDefaults' => array (
				'label' => false,
				'div' =>false,
				'class' => 'form-control'
				),
				'class' => 'well',
				'id' => 'form_change_profile'
			));
		?>
		<div class="form-group">
			<?php echo $this->Form->input('full_name', array(  
			    'placeholder' => '名前',
			    'style' => 'width:260px;',
			    'label' => '名前',
				'value' => $data["User"]["full_name"],
				'required' => false
			)); ?>
    	</div>
    	<div class="form-group">
			<?php echo $this->Form->input('address', array(  
			    'placeholder' => 'アドレス',
			    'style' => 'width:260px;',
			    'label' => 'アドレス',
				'value' => $data["User"]["address"],
				'required' => false
			)); ?>
    	</div>
    	<div class="form-group">
			<?php echo $this->Form->input('phone', array(  
			    'placeholder' => '電話番号',
			    'style' => 'width:260px;',
			    'label' => '電話番号',
				'value' => $data["User"]["phone"],
				'required' => false
			)); ?>
    	</div>
    	<div class="form-group">
			<?php echo $this->Form->input('credit_number', array(  
			    'placeholder' => '銀行アカウント',
			    'style' => 'width:260px;',
			    'label' => '銀行アカウント',
				'value' => $data["User"]["credit_number"],
				'required' => false
			)); ?>
    	</div>
    	<div class="form-group">
			<?php echo $this->Form->input('email', array(  
			    'placeholder' => 'メール',
			    'style' => 'width:260px;',
			    'label' => 'メール',
				'value' => $data["User"]["email"],
				'required' => false
			)); ?>
    	</div>
    	<?php echo $this->Form->submit('Save', array(  
		    'div' => false,  
		    'class' => 'btn btn-primary'  
		)); ?>
		<?php echo $this->Form->button("Reset", array(
			'class' => 'btn btn-default',
			'type' => 'reset',
			'id' => 'reset'
		));?>
    	<?php echo $this->Form->end(); ?>
	</div>
</div>