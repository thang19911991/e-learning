<div>
<h1>授業作成</h1>
</div>
<div class="error">
	<?php 
		echo $this->Session->Flash();
	?>
</div>
<br>
<?php
echo $this->Form->create('Course',array(
		'type'=>'file',
		'inputDefaults' => array (
			'label' => false,
			'div' =>false
)
)
);
?>
<table id="infoTable">
	<tr>
		<td>
		<h3><label for="course_name">授業名 </label></h3>
		</td>
		<td><?php 
		echo $this->Form->input("course_name");
		?></td>
	</tr>
	<tr>
		<td>
		<h3><label for="description">概要 </label></h3>
		</td>
		<td><?php 
		echo $this->Form->textarea("description", array(
			'rows' => 10,
			'cols' => 50
		));
		?></td>
	</tr>
	<tr>
		<td>
		<h3><label for="tag">タグ </label></h3>
		</td>
		<td><?php 
		echo $this->Form->input("tag0",array());
		echo $this->Form->button("More tag", array(
				'class' => 'moreTag',
				'type' => 'button',
				'id' => 'mTag',
				'onclick' => 'getMoreTag();'
			));
		echo $this->Form->input("tagNumber",array(
				'id' => 'tagNumberId',
				'type' => 'hidden',
				'value' => 0
			));	
		?></td>
	</tr>
	
</table>
<h3>授業ファイル </h3>
<table id="lessonTable">
	<tr>
		<td>
			<?php
				echo $this->Form->input("lessonName0",  array(
					'label' => 'レーション名',
					'size' => '10'
				));
			?>
		</td>
		<td>
			<?php 
				echo $this->Form->file("lesson", array(
					'name' => 'lessonFile0',
					'id' => 'lessonFileId0'
				));
				?>
		</td>
		<td>
			<?php
				echo $this->Form->button("More file", array(
					'class' => 'lessonMoreFile',
					'type' => 'button',
					'id' => 'mfLesson',
					'onclick' => 'getMoreLessonFile();'
					));
				echo $this->Form->input("lessonFileNumber",array(
					'id' => 'lessonFileNumberId',
					'type' => 'hidden',
					'value' => 0
				));
			?>
		</td>
	</tr>
</table>
<h3>テストファイル </h3>
<table id="testTable">
	<tr>
		<td>
			<?php
				echo $this->Form->input("testName0",  array(
					'label' => 'テスト名&nbsp&nbsp&nbsp&nbsp&nbsp',
					'size' => '10'
				));
			?>
		</td>
		<td>
			<?php 
				echo $this->Form->file("test", array(
					'name' => 'testFile0',
					'id' => 'testFileId0'
				));
				?>
		</td>		
		<td>
			<?php 
				echo $this->Form->button("More file", array(
					'class' => 'testMoreFile',
					'type' => 'button',
					'id' => 'mfTest',
					'onclick' => 'getMoreTestFile();'
				));
				
				echo $this->Form->input("testFileNumber",array(
					'id' => 'testFileNumberId',
					'type' => 'hidden',
					'value' => 0
				));
		?>
		</td>
	</tr>
</table>
		<?php
		echo $this->Form->checkbox("checkCopyright", array(
			'value' => '0'
		)); 
		echo "アップロードファイルのCopyrightはOKか。<br><br>";
		echo $this->Form->button("Clear",array(
			'type' => 'reset'
		));
		echo $this->Form->button('Create',array(
			'controller' => 'teachers', 
			'action' => 'create_new_course',
			'onclick' => 'return checkFileName()'
		));
		echo $this->Form->end();
			?>
		
			
<script type="text/javascript">
	var countLesson = 1, countTest=1, countTag=1;
	function getMoreLessonFile(){
		$("#lessonTable").append(
				"<tr>"+
				"<td>"+
				"<label for='CourseLessonName"+countLesson+"'>"+
				"レーション名</label>"+
				"<input id='CourseLessonName"+countLesson+"' type='text' size='10' name='data[Course][lessonName"+countLesson+"]'>"+
				"</td>"+
				"<td>"+
				"<input type='file' name='lessonFile"+countLesson+"' id='lessonFileId"+countLesson+"'>"+
				"</td>"+
				"</tr>"
				);
		$("#lessonFileNumberId").val(countLesson);
		countLesson++;
	}
	
	function getMoreTestFile(){
		$("#testTable").append(
				"<tr>"+
				"<td>"+
				"<label for='CourseTestName"+countTest+"'>"+
				"テスト名&nbsp&nbsp&nbsp&nbsp&nbsp</label>"+
				"<input id='CourseTestName"+countTest+"' type='text' size='10' name='data[Course][testName"+countTest+"]'>"+
				"</td>"+
				"<td>"+
				"<input type='file' name='testFile"+countTest+" id='lessonFileId"+countLesson+"''>"+
				"</td>"+
				"</tr>"
				);
		$("#testFileNumberId").val(countTest);
		countTest++;
	}

	function getMoreTag(){
		$("#infoTable").append(
			"<tr><td></td>"+
			"<td><input id='CourseTag"+countTag +"' type='text' name='data[Course][tag"+countTag+"]'></td>"
		);
		$("#tagNumberId").val(countTag);
		countTag++;
	}
	
	function checkFileName(){
		var i=0;
		var fileNumber = parseInt($("#lessonFileNumberId").val());

		var arr = new Array();
		for(i=0;i<=fileNumber;i++){
			if($("#lessonFileId"+i).val()!=""){
				if($("#CourseLessonName"+i).val()==""){
					alert("Lesson Filename null");
					return false;
				}
				else{
					if(arr.length>1){
						for(var j=0;j<arr.length;j++){
							if($("#CourseLessonName"+i).val()==arr[j]){
								alert("Lesson Filename duplicate");
								return false;
							}
						}
					}
					arr.push($("#CourseLessonName"+i).val());
				}
			}
		}
		//check upload file lesson
		if(arr.length==0){
			alert("Please upload lesson file");
			return false;
		}
		
		fileNumber = parseInt($("#testFileNumberId").val());
		arr = new Array();
		for(i=0;i<=fileNumber;i++){
			if($("#testFileId"+i).val()!=""){
				if($("#CourseTestName"+i).val()==""){
					alert("Test Filename null");
					return false;
				}
				else{
					if(arr.length>1){
						for(var j=0;j<arr.length;j++){
							if($("#CourseTestName"+i).val()==arr[j]){
								alert("Test Filename duplicate");
								return false;
							}
						}
					}
					arr.push($("#CourseTestName"+i).val());
				}
			}
		}
		//check upload file test
		if(arr.length==0){
			alert("Please upload test file");
			return false;
		}
		
		//check copyright
		if(!$("#CourseCheckCopyright").is(":checked")){
			alert("Please check copyright");
			return false;
		}
		return true;
	} 
</script>
