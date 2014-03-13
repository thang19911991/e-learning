<div>
<h1>テスト　レーアップロード
</h1>
</div>
<?php 
	echo $this->Form->create('Test',array(
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
					'label' => 'テスト名',
					'size' => '10',
					'value' => $data["Test"]["name"]
				));
			?>
		</td>	
	</tr>
	<tr>
		<td>
			<?php 
				echo $this->Form->file("test_file", array(
					'id' => 'testFileId',
					'name' => 'testFile'
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
				'controller' => 'tests', 
				'action' => 'reupload_test',
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
		if(!$("#TestCheckCopyright").is(":checked")){
			alert("Please check copyright");
			return false;
		}
		return true;
	}
</script>