<div class="index">

	<h2>コースを見る</h2>
	<div align="right" style="font-weight: bolder; ">
	
<?php echo count($likes);?>
いいね！&nbsp;&nbsp;
<?php
$check_like = 0;
foreach ( $likes as $tmp ) {
	if ($tmp ["Like"] ["student_id"] == $id) {
		$check_like = 1;
		break;
	}
}
if ($check_like == 1) {
	echo "<button disabled=\"disabled\">いいね</button>";
} else {
	echo "<button class=\"button_like\" student_id=\"" . $id . " \"course_id=\"" . $courses [0] ['Course'] ['id'] . "\">いいね</button>";
}

$check_report=0;
foreach ( $reports as $tmp ) {
	if ($tmp ["StudentCourseReport"] ["student_id"] == $id) {
		$check_report = 1;
		break;
	}
}
if ($check_report == 1) {
	echo "<button disabled=\"disabled\" style=\"margin-left: 20px;\">レポート</button>";
} else {
	echo "<button class=\"button_report\"  style=\"margin-left: 20px;\" student_id=\"" . $id . " \"course_id=\"" . $courses [0] ['Course'] ['id'] . "\">レポート</button>";
}
?>
</div>

<?php $tags = array(); ?>
<?php foreach($courses[0]['Tag'] as $t): ?>
	<?php  $tags[] = $t['tag_name']; ?>
<?php endforeach; ?>
<?php
?>

<table>
		<tr>
			<td><h3>
					<label for="course_name">授業名</label>
				</h3></td>
			<td>
		<?php echo $this->Form->input('course_name',array('required' => 'false','readonly' => "readonly", 'label' => false,'value' => $courses[0]['Course']['course_name'])); ?>		
	</td>
		</tr>
		<tr>
			<td><h3>
					<label for="tag">タグ</label>
				</h3></td>
			<td>
				<ul id="tag_ul">
			<?php foreach ($tags as $tag): ?>
			<li><span id="tag_name_span"><?php echo $tag; ?></span></li>
			<?php endforeach; ?>
		</ul>
			</td>
		</tr>
		<tr>
			<td><h3>
					<label for="description">概要</label>
				</h3></td>
			<td>
		<?php echo $this->Form->input('description',array('required' => 'false', 'readonly' => "readonly", 'label' => false, 'value' => $courses[0]['Course']['description'])); ?>		
	</td>
		</tr>
		<tr>
			<td><h3>
					<label for="chapter">チャプター</label>
				</h3></td>
			<td>
		<?php
		$documents = $courses [0] ['Document'];
		foreach ( $documents as $document ) :
			?>
		<div>
		<?php
			$check_active = 0;
			if ($document ["status"] == "inactive") {
				$check_active = 1;
			}
			
			echo $this->Html->link ( $document ["name"], array (
					'controller' => 'student',
					'action' => 'std_view_document',
					$document ["id"] 
			), array (
					"check_active" => $check_active,
					"class" => 'document' 
			) );
			
			?></div>
		<?php endforeach; ?>
</td>
		</tr>
		<tr>
			<td><h3>
					<label for="test">テスト</label>
				</h3></td>
			<td>
		<?php
		$tests = $courses [0] ['Test'];
		foreach ( $tests as $test ) :
			?>
		<div><?php
			echo $this->Html->link ( $test ["name"], array (
					'controller' => 'student',
					'action' => 'std_view_test',
					$test ["id"] 
			) );
			?></div>
		<?php endforeach; ?>
	</td>
		</tr>
	</table>
</div>

<script>
$(function(){
	$(".button_like").click(function(){
		var student_id = $(this).attr("student_id");
		var course_id = $(this).attr("course_id");
			$.ajax({				
				type : "POST",
				url : '<?php echo $this->base. "/student/std_like" ?>',
				data : {student_id:student_id, course_id:course_id},
				success : function(data){					
				}
			});
			window.location = "<?php echo $this->Html->url(array('controller' => 'student', 'action' => 'detail_course', $courses[0]['Course']['id'])); ?>"
	});

	$(".button_report").click(function(){
		var student_id = $(this).attr("student_id");
		var course_id = $(this).attr("course_id");
		var data=prompt("レポートの理由", "");
		if(data==null)
		{
		return false;
		}else{
			
			$.ajax({				
				type : "POST",
				url : '<?php echo $this->base. "/student/course_report" ?>',
				data : {student_id:student_id, course_id:course_id, content:data},
				success : function(data){					
				}
			});
			window.location = "<?php echo $this->Html->url(array('controller' => 'student', 'action' => 'std_detail_course', $courses[0]['Course']['id'])); ?>"
		}
	});

	$(".document").click(function(){
		var check_active = $(this).attr("check_active");
                                    if(check_active==0)
                                   {
                                        return true;
                }else{
			alert("ドキュメントがロックした。");
			return false;	
        }

});		
	
});
</script>