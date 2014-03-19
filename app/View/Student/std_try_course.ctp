<div class="index">

<h2>コースを見る</h2>

<?php $tags = array(); ?>
<?php foreach($courses[0]['Tag'] as $t): ?>
	<?php  $tags[] = $t['tag_name']; ?>
<?php endforeach; ?>
<?php
?>

<table>
<tr>
	<td><h3><label for="course_name">授業名</label></h3></td>
	<td>
		<?php echo $this->Form->input('course_name',array('required' => 'false','readonly' => "readonly", 'label' => false,'value' => $courses[0]['Course']['course_name'])); ?>		
	</td>
</tr>
<tr>
	<td><h3><label for="tag">タグ</label></h3></td>
	<td>
		<ul id="tag_ul">
			<?php foreach ($tags as $tag): ?>
			<li>
				<span id="tag_name_span"><?php echo $tag; ?></span>
			</li>
			<?php endforeach; ?>
		</ul>
	</td>
</tr>
<tr>
	<td><h3><label for="description">概要</label></h3></td>
	<td>
		<?php echo $this->Form->input('description',array('required' => 'false', 'readonly' => "readonly", 'label' => false, 'value' => $courses[0]['Course']['description'])); ?>		
	</td>
</tr>
<tr>
	<td><h3><label for="chapter">チャプター</label></h3></td>
	<td>
		<?php
			$documents = $courses[0]['Document'];
			foreach ($documents as $document):
		?>
		<div><?php echo $document["name"]; ?></div>
		<?php endforeach; ?>
	</td>
</tr>
<tr>
       <td><h3><label for="test">テスト</label></h3></td>
	<td>
		<?php
			$tests = $courses[0]['Test'];
			foreach ($tests as $test):
		?>
		<div><?php echo $test['name']; ?></div>
		<?php endforeach; ?>
	</td>
</tr>
</table>
</div>