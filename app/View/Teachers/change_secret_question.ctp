
<div>
<h1>秘密質問変化</h1>
</div>
<?php
echo $this->Form->create('SQ',array(
		'inputDefaults' => array (
			'label' => false,
			'div' =>false
)
)
);
?>
<div><?php 
echo $this->Form->input("new_question", array(
		'label' => '新しい質問',
		'id' => 'questionId'
		));
		?></div>
<div><?php 
echo $this->Form->input("new_answer", array(
		'label' => '新しい答え',
		'id' => 'answerId'
		));
		?></div>
<div><?php 
echo $this->Form->button("save", array(
		'id' => 'submitBto',
		'label' => 'Save',
		'type' => 'submit',
		'onclick' => 'return checkSave()'
		));
		echo $this->Form->End();
		?></div>

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
