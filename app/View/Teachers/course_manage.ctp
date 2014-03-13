<?php if(!empty($courses)):?>
<div class="users index">
	<h2><?php echo $courses["Course"]["course_name"];?></h2>
	<p style="font-size: large; font-weight: bold;">コースの学生管理</p>
	<table>
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
		) );
	} else {
		echo "<a href=\"\" class=\"confirm\" student_id=\"".$tmp['StudentCourseLearn']['student_id']." \"course_id=\"".$tmp['StudentCourseLearn']['course_id']."\"  learn_id=\"".$tmp["StudentCourseLearn"]["id"]."\" >Cancel</a>";		
	}
	echo "</td>";
	echo "</tr>";
}
?>
</table>
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

<div class="actions">
	<ul>
		<li>
			<?php echo $this->Html->link( "ホームページ", array('controller' => 'teachers', 'action'=>'index')); ?>
		</li>
		<li>
			<?php echo $this->Html->link( "コースリストを見る",   array('controller' => 'teachers', 'action'=>'view_list_course')); ?>
		</li>
		<li>
			<?php echo $this->Html->link( "コース編集",   array('controller' => 'teachers', 'action'=>'edit_course',$courses['Course']['id'])); ?>
		</li>
		<li>
			<?php echo $this->Html->link( "コース作成",   array('controller' => 'teachers', 'action'=>'create_new_course')); ?>
		</li>
		<li>
			<?php echo $this->Html->link( "コースの学生管理",   array('controller' => 'teachers', 'action'=>'course_manage', $courses['Course']['id'])); ?>
		</li>
		<li>
			<?php echo $this->Html->link( "学生のテスト見る",   array('controller' => 'teachers', 'action'=>'view_test_result', $courses['Course']['id'])); ?>
		</li>
		<li>
		<?php if($current_user): ?>
		<?php echo $this->Html->link( "ログアウト", array('controller' => 'teachers', 'action'=>'logout')); ?>
		<?php endif; ?>
		</li>
	</ul>
</div>
<?php else: ?>
<h3><?php echo "そのコースが既存しない"; ?></h3>
<?php endif; ?>