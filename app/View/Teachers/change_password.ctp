<style>
.main {
	margin-top: 50px;
}
</style>
<div class="col-sm-6 col-sm-offset-5 col-md-6 col-md-offset-2 main">
	<div class="row">
		<?php //echo $this->Session->flash(); ?>
		<span class="label label-danger" style="font-size: 21px;" >パスワード変化</span>
		<?php echo $this->Form->create('Pass',array(
			'inputDefaults' => array (
				'label' => false,
				'div' =>false,
				'class' => 'form-control'
			),
			'class' => 'well')
		);?>
		<div class="form-group">
			<?php 
				echo $this->Form->input("new_pass", array(
					'label' => '新しいパスワード',
					'type' => 'password',
					'id' => 'newPass'
				));
			?>
		</div>
		<div class="form-group">
			<?php 
				echo $this->Form->input("re_pass", array(
					'label' => 'もう一度パスワード',
					'type' => 'password',
					'id' => 'rePass'
				));
			?>
		</div>
		<div class="form-group">
			<?php 
				echo $this->Form->button("save", array(
					'id' => 'submitBto',
					'class' => 'btn btn-primary',
					'label' => 'Save',
					'type' => 'submit',
					'onclick' => 'return checkSave()'
				));
				echo $this->Form->End();
			?>
		</div>
	</div>
</div>
<script type="text/javascript">
	function checkSave(){
		if($("#newPass").val()!=$("#rePass").val()){
			alert("Pass and Repass is different");
			return false;
		}
		if($("#newPass").val()==''){
			alert("Pass is null");
			return false;
		}
		return true;
	}
</script>