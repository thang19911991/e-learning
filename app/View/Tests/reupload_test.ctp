<style>
.main {
	margin-top: 50px;
}
</style>
<div class="col-sm-9 col-sm-offset-5 col-md-9 col-md-offset-2 main">
	<div class="row">		
		<span class="label label-danger" style="font-size: 21px;" >テストを再アップロード</span>
		<?php echo $this->Form->create('Test',array(
			'type'=>'file',
			'class' => 'well',
			'inputDefaults' => array (
				'label' => false,
				'div' =>false,
				'class' => 'form-control',
				)
			));
		?>
		<div class="form-group">
			<?php 
				echo $this->Form->input("name", array(
					'label' => 'テスト名',
					'size' => '10',
					'value' => $data["Test"]["name"]
				));
			?>
		</div>
		<div class="form-group">
			<?php 
				echo $this->Form->file("test_file", array(
					'id' => 'testFileId',
					'name' => 'testFile'
				)); 
			?>
		</div>
		<div class="form-group">
			<?php 
				echo $this->Form->checkbox("checkCopyright", array(
					'value' => '0'
				)); 
				echo "アップロードファイルのCopyrightはOKか。<br><br>";
			?>
		</div>
		<?php 
			echo $this->Form->button("Clear",array(
				'class' => 'btn btn-default',
				'style' => 'margin-right:5px',
				'type' => 'reset'
			));
			echo $this->Form->button('Save',array(
				'class' => 'btn btn-primary',
				'controller' => 'tests', 
				'action' => 'reupload_test',
				'type' => 'submit',
				'onclick' => 'return checkBeforeSubmit()'
			));
			echo $this->Form->end();
		?>
	</div>
</div>

<script type="text/javascript">
	function checkBeforeSubmit(){
		//check copyright
		if(!$("#TestCheckCopyright").is(":checked")){
			alert("Please check copyright");
			return false;
		}
		return true;
	}
</script>