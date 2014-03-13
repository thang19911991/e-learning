<div class="index">
<h2>パスワード変化</h2>
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

</div>

<div class="actions">
	<ul>
		<li>
			<?php echo $this->Html->link( "ホームページ", array('controller' => 'teachers', 'action'=>'index')); ?>
		</li>
		<li>
			<?php echo $this->Html->link( "コースリストを見る",   array('controller' => 'teachers', 'action'=>'view_list_course')); ?>
		</li>		
		<li>
			<?php echo $this->Html->link( "コース作成",   array('controller' => 'teachers', 'action'=>'create_new_course')); ?>
		</li>
		<li>
		<?php if($current_user): ?>
		<?php echo $this->Html->link( "ログアウト", array('controller' => 'teachers', 'action'=>'logout')); ?>
		<?php endif; ?>
		</li>
	</ul>
</div>