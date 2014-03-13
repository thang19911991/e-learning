<div class="index">
<h2>秘密質問変化</h2>

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