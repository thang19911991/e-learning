<div class="index">
<h2>セキュリティー質問の確認</h2>
<?php
	if(!empty($teacher['Teacher'])):
	$values = array();
	$values = array($teacher['Teacher']['verify_code']);
?>

<?php
	echo $this->Form->create("Teacher"); ?>
	<div class="input select">
	<label for="TeacherVerifyCode">セキュリティー質問</label>
	<select name="data[Teacher][verify_code]" id="TeacherVerifyCode">
		<option value="<?php echo $values[0]; ?>" selected="selected"><?php echo $values[0]; ?></option>
	</select>
	</div>
<?php
	echo $this->Form->input("verify_code_answer", array('label' => 'セキュリティー答え', 'required' => 'false'));
	echo $this->Form->end("Submit");
?>
<?php endif; ?>
</div>