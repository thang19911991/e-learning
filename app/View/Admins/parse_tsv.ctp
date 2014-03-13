<div class = 'user index'>
<h3><?php echo $test['title'];?></h3>
	
<?php
	$this->Form->create('User');
	foreach ($test['questions'] as $question) {
		$attr = array('seperator' => '<br/>');
		//echo "<h4>".$question['question']."</h4>";
		echo $this->Form->radio($question['question'], $question['answers'], $attr);
	}


?>

</div>