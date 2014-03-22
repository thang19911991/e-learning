<style>
.main {
	margin-top: 50px;
}
</style>
<div class="col-sm-9 col-sm-offset-5 col-md-9 col-md-offset-2 main">
	<div class="row">
		
		<span class="label label-danger" style="font-size: 21px;" >新ドキュメントアップロード</span>
		<?php echo $this->Form->create('Document',array(
			'type'=>'file',
			'class' => 'well',
			'inputDefaults' => array (
				'class' => 'form-control',
				'label' => false,
				'div' =>false
				)
			));
		?>
		<div class="form-group">
			<?php 
				echo $this->Form->input("name", array(
					'label' => 'ドキュメント名',
					'size' => '10'
				));
			?>
		</div>
		<div class="form-group">
			<?php 
				echo $this->Form->file("document_file", array(
					'id' => 'documentFileId',
					'name' => 'documentFile'
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
				'style' => 'margin-right:5px;',
				'type' => 'reset'
			));
			echo $this->Form->button('Save',array(
				'class' => 'btn btn-primary',
				'controller' => 'documents', 
				'action' => 'reupload_document',
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
		if(!$("#DocumentCheckCopyright").is(":checked")){
			alert("Please check copyright");
			return false;
		}
		return true;
	}
</script>
