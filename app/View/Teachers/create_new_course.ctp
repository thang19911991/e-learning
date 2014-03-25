<style>
.main {
	margin-top: 50px;
}
</style>
<div class="col-sm-6 col-sm-offset-5 col-md-6 col-md-offset-2 main">
	<div class="row">
		<?php //echo $this->Session->flash(); ?>
		<span class="label label-danger" style="font-size: 21px;" >授業作成</span>
		<?php echo $this->Form->create('Course',array(
			'type'=>'file',
			'inputDefaults' => array (
				'label' => false,
				'div' =>false,
				'class' => 'form-control'
		),
		'class' => 'well'
		));?>
		
		<div id="infoTable">
			<div class="form-group">
			<?php echo $this->Form->input("course_name", array(
				'label' => '授業名',
			));?>
			</div>
			
			<div class="form-group">
			<label for="description">概要</label><br>
			<?php echo $this->Form->textarea("description", array(
					'class' => 'form-control',
					'rows' => 10,
					'cols' => 50
			));?>
			</div>
			
			<div class="form-group">
				<div class="form-inline">
				<label>タグ</label>
				<?php echo $this->Form->button("More tag", array(
						'class' => 'moreTag btn btn-primary',
						'style' => 'margin-bottom:2px;float:right',
						'type' => 'button',
						'id' => 'mTag',
						'onclick' => 'getMoreTag();'
					));?>
				<?php echo $this->Form->input("tagNumber",array(
						'id' => 'tagNumberId',
						'type' => 'hidden',
						'value' => 0
					));	?>
				</div>
				<?php echo $this->Form->input("tag0",array(
					'class' => 'form-control',
					'label' => false
				));?>
			</div>
		</div>
		
		<h3>授業ファイル</h3>
		<div id="lessonTable">
			<div class="form-group">
				<div class="form-inline">
				<label>ドキュメント名</label>
				<?php
					echo $this->Form->button("More file", array(
						'class' => 'lessonMoreFile btn btn-primary',
						'style' => 'margin-bottom:2px;float:right',
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
				</div>
				<?php
					echo $this->Form->input("lessonName0",  array(
						'size' => '10'
					));
				?>
				<?php
					echo $this->Form->file("lesson", array(
						'name' => 'lessonFile0',
						'id' => 'lessonFileId0'
					));
				?>
			</div>
		</div>
		
		<h3>テストファイル </h3>
		<div id="testTable">
			<div class="form-group">
				<div class="form-inline">
				<label>テスト名</label>
				<?php 
					echo $this->Form->button("More file", array(
						'class' => 'testMoreFile btn btn-primary',
						'style' => 'margin-bottom:2px;float:right',
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
				</div>
				<?php
					echo $this->Form->input("testName0",  array(
						'size' => '10'
					));
				?>
				<?php
					echo $this->Form->file("test", array(
						'name' => 'testFile0',
						'id' => 'testFileId0'
					));
				?>
			</div>			
		</div>
		
		<div class="form-group">
		<?php echo $this->Form->checkbox("checkCopyright", array(
				'value' => '0'
		));
		echo "アップロードファイルのCopyrightはOKか。"; ?>
		</div>
		
		<?php
		echo $this->Form->button("Clear",array(
				'style' => 'margin-right:10px;',
				'class' => 'btn btn-default',
				'type' => 'reset'
		));
		echo $this->Form->button('Create',array(
				'class' => 'btn btn-primary',
				'controller' => 'teachers', 
				'action' => 'create_new_course',
				'onclick' => 'return checkFileName()'
		));
		echo $this->Form->end();
		?>
		</div>
</div>
	
	
<script type="text/javascript">
	var countLesson = 1, countTest=1, countTag=1;
	function getMoreLessonFile(){
		$("#lessonTable").append(
				"<label for='CourseLessonName"+countLesson+"'>ドキュメント名</label>"+
				"<div class='form-group'>" +
				"<input class='form-control' id='CourseLessonName"+countLesson+"' type='text' size='10' name='data[Course][lessonName"+countLesson+"]'>"+
				"<input type='file' name='lessonFile"+countLesson+"' id='lessonFileId"+countLesson+"'>"+
				"</div>"				
				);
		$("#lessonFileNumberId").val(countLesson);
		countLesson++;
	}
	
	function getMoreTestFile(){
		$("#testTable").append(
				"<label for='CourseTestName"+countTest+"'>テスト名</label>"+
				"<div class='form-group'>" +
				"<input class='form-control' id='CourseTestName"+countTest+"' type='text' size='10' name='data[Course][testName"+countTest+"]'>"+
				"<input type='file' name='testFile"+countTest+" id='lessonFileId"+countLesson+"''>"+
				"</div>"
				);
		$("#testFileNumberId").val(countTest);
		countTest++;
	}

	function getMoreTag(){
		$("#infoTable").append(
			"<div class='form-group'>"+
			"<input class='form-control' id='CourseTag"+countTag +"' type='text' name='data[Course][tag"+countTag+"]'>"+
			"</div>"
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