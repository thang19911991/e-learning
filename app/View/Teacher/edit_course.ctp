<div class="index">
<h2>コース情報変化</h2>
<?php $tags = array(); ?>
<?php foreach($courses[0]['Tag'] as $t): ?>
	<?php  $tags[] = $t['tag_name']; ?>
<?php endforeach;?>

<?php echo $this->Form->create('Course'); ?>
<table>
<tr>	
	<td><h3><label for="course_name">授業名</label></h3></td>
	<td>
		<?php echo $this->Form->input('course_name',array('required' => 'false', 'label' => false,'value' => $courses[0]['Course']['course_name'])); ?>		
	</td>
</tr>
<tr>
	<td><h3><label for="tag">タグ</label></h3></td>
	<td>
		<?php echo $this->Form->input('tag',array('label' => false, 'type' => 'select', 'options' => $tags)); ?>
		<?php echo $this->Form->input("tag_name", array('label' => false,'id' => 'tag_name')); ?>
			
		<?php echo $this->Form->button("Add tag", array(
				'class' => 'moreTag',
				'type' => 'button',
				'id' => 'mTag'				
			)); ?>
	</td>
</tr>
<tr>
	<td><h3><label for="description">概要</label></h3></td>
	<td>
		<?php echo $this->Form->input('description',array('required' => 'false', 'label' => false, 'value' => $courses[0]['Course']['description'])); ?>		
	</td>
</tr>
<tr>
	<td></td>
	<td>
		<?php echo $this->Form->end('Submit',array('controller' => 'teacher', 'action' => 'edit_course')); ?>		
	</td>
</tr>
</table>
</div>

<script type="text/javascript">	
	$(function(){
		$("#mTag").click(function(){
			var tag_name = $("#tag_name").val();
			
		});
	});
</script>
<div class="actions">
	<ul>
		<li>
			<?php echo $this->Html->link( "コースを見る",   array('controller' => 'teacher', 'action'=>'view_course')); ?>
		</li>
		<li>
			<?php echo $this->Html->link( "コース作成",   array('controller' => 'teacher', 'action'=>'add_course')); ?>
		</li>
		<li>
		<?php if($current_user): ?>
		<?php echo $this->Html->link( "ログアウト", array('controller' => 'teacher', 'action'=>'logout')); ?>
		<?php endif; ?>
		</li>
	</ul>
</div>