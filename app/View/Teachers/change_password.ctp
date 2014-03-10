<div>
<h1>パスワード変化</h1>
</div>
<?php
echo $this->Form->create('Pass',array(
		'inputDefaults' => array (
			'label' => false,
			'div' =>false
)
)
);
?>
<div>
<?php 
	echo $this->Form->input("new_pass", array(
		'label' => '新しいパスワード',
		'type' => 'password',
		'id' => 'newPass'
	));
?>
</div>
<div>
<?php 
	echo $this->Form->input("re_pass", array(
		'label' => 'もう一度パスワード',
		'type' => 'password',
		'id' => 'rePass'
	));
?>
</div>
<div>
<?php 
	echo $this->Form->button("save", array(
		'id' => 'submitBto',
		'label' => 'Save',
		'type' => 'submit',
		'onclick' => 'return checkSave()'
	));
	echo $this->Form->End();
?>
</div>

<script type="text/javascript">
	function checkSave(){
		//alert("Duc dep trai");
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