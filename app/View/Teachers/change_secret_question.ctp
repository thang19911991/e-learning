<style>
.main {
	margin-top: 50px;
}
</style>
<div class="col-sm-6 col-sm-offset-5 col-md-6 col-md-offset-2 main">
	<div class="row">
		<?php //echo $this->Session->flash(); ?>
		<span class="label label-danger" style="font-size: 21px;" >秘密質問変化</span>
		<?php echo $this->Form->create('SQ',array(
			'inputDefaults' => array (
				'class' => 'form-control',
				'label' => false,
				'div' =>false
		),
		'class' => 'well'
		));?>
		<div class="form-group">
		<?php echo $this->Form->input("new_question", array(
			'label' => '新しい質問',
			'id' => 'questionId'
			));
			?>
		</div>
		<div class="form-group">
		<?php echo $this->Form->input("new_answer", array(
			'label' => '新しい答え',
			'id' => 'answerId'
			));
		?>
		</div>
		<div class="form-group">
		<?php echo $this->Form->button("Save", array(
			'class' => 'btn btn-primary',
			'id' => 'submitBto',
			'label' => 'Save',
			'type' => 'submit',
			'onclick' => 'return checkSave()'
		));	?>
		</div>
		<?php echo $this->Form->End(); ?>
	</div>
</div>

<script type="text/javascript">
	function checkSave(){
		if($("#questionId").val()==''){
			alert("Question is null");
			return false;
		}
		if($("#answerId").val()==''){
			alert("Answer is null");
			return false;
		}
		return true;
	}
</script>