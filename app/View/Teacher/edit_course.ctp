<div class="index">
<h2>コース情報変化</h2>
<?php $tags = array(); ?>
<?php foreach($courses[0]['Course_Tag'] as $t): ?>
	<?php  $tags[] = $t['Tag']['tag_name']; ?>
<?php endforeach;?>

<?php echo $this->Form->create('Course'); ?>
<?php echo $this->Form->input('course_name',array('required' => 'false', 'label' => 'コース名','value' => $courses[0]['Course']['course_name'])); ?>
<?php echo $this->Form->input('tag',array('label' => 'タグ', 'type' => 'select', 'options' => $tags)); ?>
<?php echo $this->Form->input('description',array('required' => 'false', 'label' => '概要', 'value' => $courses[0]['Course']['description'])); ?>
<?php echo $this->Form->end('Submit',array('controller' => 'teacher', 'action' => 'edit_course')); ?>
</div>

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