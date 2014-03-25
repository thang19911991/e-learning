<style>
.main {
	margin-top: 50px;
}
</style>
<div class="col-sm-6 col-sm-offset-5 col-md-6 col-md-offset-2 main">
	<div class="row">
		<?php //echo $this->Session->flash(); ?>
		<?php if(!empty($courses)):?>
		<span class="label label-danger" style="font-size: 21px;" >コースの学生管理</span>
		<h2><?php echo $courses["Course"]["course_name"];?></h2>
		
		<table class="table table-hover table-bordered">
		<tr>
			<td>学生のユーザ名</td>
			<td>状態</td>
			<td>コースを終わる日</td>
			<td>テスト結果</td>
			<td>操作</td>
		</tr>
			<?php
			foreach ( $learn as $tmp ) {	
				echo "<tr>";
				echo "<td>";
				echo $tmp["StudentCourseLearn"]["student_name"];
				echo "</td>";
				echo "<td>";
				echo $tmp ["StudentCourseLearn"] ["status"];
				echo "</td>";
				echo "<td>";
				echo $tmp ["StudentCourseLearn"] ["end_date"];
				echo "</td>";
				echo "<td>";
				echo $this->Html->link ( "テスト結果", array (
						'action' => 'course_manage',
						19 
				) );
				echo "</td>";
				echo "<td>";
				
				if ($tmp ["StudentCourseLearn"] ["status"] == "cancel") {
					echo $this->Html->link ( "UnCancel", array (
							'controller' => 'teacher2',
							'action' => 'course_unban',
							"?" => array (
									"student_id" => $tmp["StudentCourseLearn"]["student_id"],
									"course_id" => $tmp["StudentCourseLearn"]["course_id"],
									"id" => $tmp["StudentCourseLearn"]["id"]	
							) 
					));
				} else {
					echo "<a href=\"\" class=\"confirm\" student_id=\"".$tmp['StudentCourseLearn']['student_id']." \"course_id=\"".$tmp['StudentCourseLearn']['course_id']."\"  learn_id=\"".$tmp["StudentCourseLearn"]["id"]."\" >Cancel</a>";		
				}
				echo "</td>";
				echo "</tr>";
			}
			?>
	</table>
		<?php else: ?>
		<span class="label label-danger" style="font-size: 20px"><?php echo "そのコースIDが既存しない";?></span>
		<?php endif; ?>
	</div>
</div>

<script>
$(function(){
	$(".confirm").click(function(){
		var student_id = $(this).attr("student_id");
		var course_id = $(this).attr("course_id");
		var learn_id = $(this).attr("learn_id");
		var data=prompt("禁止の理由", "");
		if(data==null)
		{
		return false;
		}else{
			$.ajax({				
				type : "POST",
				url : '<?php echo $this->base. "/teachers/course_ban" ?>',
				data : {student_id:student_id, course_id:course_id, content:data,learn_id:learn_id},
				success : function(data){					
				}
			});
			return true;
		}
	});	
});
</script>