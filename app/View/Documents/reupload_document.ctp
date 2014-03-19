<div>
<h1>ドキュメント　レーアップロード
</h1>
</div>
<?php 
	echo $this->Form->create('Document',array(
			'type'=>'file',
			'inputDefaults' => array (
				'label' => false,
				'div' =>false
				)
			)
		);
?>
<div>
<table>
	<tr>
		<td>
			<?php 
				echo $this->Form->input("name", array(
					'label' => 'ドキュメント名',
					'size' => '10',
					'value' => $data["Document"]["name"]
				));
			?>
		</td>	
	</tr>
	<tr>
		<td>
			<?php 
				echo $this->Form->file("document_file", array(
					'id' => 'documentFileId',
					'name' => 'documentFile'
				)); 
			?>
		</td>
	</tr>
	<tr>
		<td>
			<?php 
				echo $this->Form->checkbox("checkCopyright", array(
					'value' => '0'
				)); 
				echo "アップロードファイルのCopyrightはOKか。<br><br>";
			?>
		</td>
	</tr>
	<tr>
		<td>
		<?php 
			echo $this->Form->button("Clear",array(
				'type' => 'reset'
			));
			echo $this->Form->button('Save',array(
				'controller' => 'documents', 
				'action' => 'reupload_document',
				'type' => 'submit',
				'onclick' => 'return checkBeforeSubmit()'
			));
			echo $this->Form->end();
		?>
		</td>
	</tr>
</table>
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