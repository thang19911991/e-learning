<div>
<h1>禁止学生</h1>
</div>
<div class="error">
	<?php 
		echo $this->Session->Flash();
	?>
</div>
<?php
echo $this->Form->create('Ban',array(
		'inputDefaults' => array (
			'label' => false,
			'div' =>false
)
)
);
?>
<div>
	<?php 
		echo $this->Form->input("banStudent", array(
			'label' => '学生のユーザ名',
			'id' => 'banStudent'
		));
	?>
</div>
<div>
	<?php 
		echo $this->Form->input("banReason", array(
			'label' => '理由',
			'id' => 'banReason'
		));
	?>
</div>
<div>
	<?php 
		echo $this->Form->button("save", array(
			'id' => 'submitBto',
			'label' => 'Ban',
			'type' => 'submit',
			'onclick' => 'return checkSave()'
		));
		echo $this->Form->End();
	?>
</div>
<div id="banList">
	<?php
		echo $this->Html->link ( "禁止したリスト", array (
				'controller' => 'Teachers',
				'action' => 'view_ban_list' 
		) );
	?>
</div>

<script type="text/javascript">
	function checkSave(){
		if($("#banStudent").val()==''){
			alert("学生のユーザ名が空き");
			return false;
		}

		if($("#banReason").val()==''){
			alert("理由が空き");
			return false;
		}
		return true;
	}
</script>