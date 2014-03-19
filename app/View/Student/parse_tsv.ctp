<div class='user index'>
<h3>テストのタイトル：<?php echo $test['title'];?></h3>
--------------------------------------------------------------------------------------------------
<?php
echo $this->Form->create('User');
?>
<table>
	<tr>
		<td><?php
		foreach ($test['questions'] as $question) {
			$attr = array('seperator' => '<br/>');
			//echo "<h4>".$question['question']."</h4>";
			echo $this->Form->radio($question['question'], $question['answers'], $attr);
			echo "--------------------------------------------------------------------------------------------------";
		}
		?></td>
	</tr>
</table>
		<?php
		echo $this->Form->end('Submit');
		?></div>
