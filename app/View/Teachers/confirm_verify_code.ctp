<div class="row">
    <?php echo $this->Session->flash(); ?>
    <div class="col-md-8 col-md-offset-2">
    	<div class="jumbotron">
    		<h2>セキュリティー質問の確認</h2>
			<?php
				if(!empty($teacher['Teacher'])):
				$values = array();
				$values = array($teacher['Teacher']['verify_code']);
			?>
			
			<?php
				echo $this->Form->create("Teacher", array(
					'inputDefaults' => array(
						'div' => false,
				        'label' => false,
				        'wrapInput' => false,
				        'class' => 'form-control',
					)
				)); ?>
				<div class="input select">
				<label for="TeacherVerifyCode">セキュリティー質問</label>
				<select name="data[Teacher][verify_code]" id="TeacherVerifyCode">
					<option value="<?php echo $values[0]; ?>" selected="selected"><?php echo $values[0]; ?></option>
				</select>
				</div>
			<?php
				echo $this->Form->input("verify_code_answer", array(
					'label' => 'セキュリティー答え',
					'class' => 'form-control',
					'required' => 'false'));
				
				echo $this->Form->submit('Submit', array(  
				    'div' => false,  
				    'class' => 'btn btn-primary'  
				));
				echo $this->Form->end();
			?>
			<?php endif; ?>
    	</div>
    </div>
</div>