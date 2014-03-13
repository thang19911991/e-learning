<div class="users index">
<h2>リストコース</h2>	
	<div style="margin-top: 20px">
		<p style="font-size: large; font-weight: bold;">
			<strong>君の買ったコース</strong>
		</p>
	<?php
	echo "<ul id=\"check_view\">";
	$flag = 0;
	$flag_time = 0;
	$flag_active = 0;
	$flag_teacher_ban = 0;
	
	foreach ( $course_learn as $tmp ) {
		
		$flag = 0;
		$check_ban = $tmp ['courses'] ['id'];
		
		foreach ( $course_ban as $ban ) {
			if ($check_ban == $ban ['students_courses_ban'] ['course_id']) {
				$flag = 1;
				break;
			}
		}
		
		$flag_time = 0;
		// Check Time here
		$end_time = $tmp ["students_courses_learn"] ["end_date"];
			
		if (strtotime ( $end_time )  > time ()) {
			$flag_time = 1;
		}
		
		// Check Course Active here
		$flag_active = 0;
		$course_active = $tmp ["courses"] ["status"];
		if ($course_active == "inactive") {
			$flag_active = 1;
		}
		// Check Teacher Ban
		
		if($flag==0)
		{
		$check_teacher_ban = $tmp ['courses'] ['teacher_id'];
		foreach ( $teacher_ban as $ban ) {
			if ($check_teacher_ban == $ban ['bans'] ['teacher_id']) {
				$flag = 1;
				break;
			}
		}
		}
		
		
		echo "<li>";
		echo $tmp ["courses"] ["course_name"];
		?>
		&nbsp;&nbsp;
		<?php
		echo $this->Html->link ( "見る", array (
				'controller' => 'student',
				'action' => 'std_detail_course',
				$tmp ['courses'] ['id'] 
		), array (
				"check_ban" => $flag,
				"check_time" => $flag_time,
				"check_active" => $flag_active 
		) );
		echo "</li>";
	}
	echo "</ul>";
	?>
	</div>
	<div style="margin-top: 20px">
		<p style="font-size: large; font-weight: bold;">
			<strong>他のコース</strong>
		</p>
	<?php
	echo "<ul>";
	$flag_active = 0;
	$flag = 0;
	
	foreach ( $course_recomment as $tmp ) {
		$flag = 0;
		$check_ban = $tmp ['courses'] ['id'];
		foreach ( $course_ban as $ban ) {
			if ($check_ban == $ban ['students_courses_ban'] ['course_id']) {
				$flag = 1;
				break;
			}
		}
		// Check Course Active here
		$flag_active = 0;
		$course_active = $tmp ["courses"] ["status"];
		if ($course_active == "inactive") {
			$flag_active = 1;
		}
		//Check teacher ban
		if($flag==0)
		{
			$check_teacher_ban = $tmp ['courses'] ['teacher_id'];
			foreach ( $teacher_ban as $ban ) {
				if ($check_teacher_ban == $ban ['bans'] ['teacher_id']) {
					$flag = 1;
					break;
				}
			}
		}
		
		echo "<li>";
		echo $tmp ["courses"] ["course_name"];
		?>
				&nbsp;&nbsp;
				<?php
		echo $this->Html->link ( "見る", array (
				'controller' => 'student',
				'action' => 'std_try_course',
				$tmp ['courses'] ['id'] 
		), array (
				"check_ban" => $flag,
				"check_active" => $flag_active,
				"id" => "check_try" 
		) );
		?>
		&nbsp;&nbsp;
		<?php
		echo $this->Html->link ( "買う", array (
				'controller' => 'student',
				'action' => 'std_buy',
				$tmp ['courses'] ['id'] 
		), array (
				"check_ban" => $flag,
				"check_active" => $flag_active,
				"name_course" => $tmp ["courses"] ["course_name"],
				"id" => "check_buy" 
		) );
		echo "</li>";
	}
	echo "</ul>";
	?>
</div>
</div>

<script>
	$(function(){
		$("#check_view li a").click(function(){
			var check_ban = $(this).attr("check_ban");
			var check_time = $(this).attr("check_time");
			var check_active = $(this).attr("check_active");
			if(check_ban==0){
                                if(check_time==0)
                                {
                                        if(check_active==0)
                                        {
                                	return true;
                                        }else
                                        {
                                        	alert("コースは活動していない");
                                        	return false;
                                        }
                                    
                                }else
                                {
                                	alert("コースは有効期限です。");
                                	return false;
                                }
				
			}else{
				alert("アカウントが禁止された。");
				return false;	
			}
		});

		
		$("#check_buy").click(function(){

			var check_ban = $(this).attr("check_ban");
			var check_active = $(this).attr("check_active");
			var name_course = $(this).attr("name_course");
			if(check_ban==0){
                                        if(check_active==0)
                                       {
                                       var data=confirm("「"+name_course+"」値段は２万ドンです。君は「"+name_course+"」を買いますか。");
                                       if(data==true)
                                       {
                                           return true;
                                       }else
                                       {
                                    	   return false;
                                       }
                                       }else
                                       {
                                        	alert("Khoa hoc chua active");
                                        	return false;
                                       }
			}else{
				alert("アカウントが禁止された。");
				return false;	
	        }
	});		
		$("#check_try").click(function(){

			var check_ban = $(this).attr("check_ban");
			var check_active = $(this).attr("check_active");

			if(check_ban==0){
                                        if(check_active==0)
                                       {
                                         return true;
                                       }else
                                       {
                                        	alert("コースは活動していない");
                                        	return false;
                                       }
			}else{
				alert("アカウントが禁止された。");
				return false;	
	        }
	});		
	});
</script>
