<div class="index">
<h2>コース情報変化</h2>
<?php if(!empty($courses)): ?>
<?php $tags = array(); ?>
<?php foreach($courses['Tag'] as $t): ?>
	<?php  $tags[] = $t['tag_name']; ?>
<?php endforeach;?>

<?php echo $this->Form->create("Course", array('url' => array('controller' => 'teachers', 'action' => 'edit_course', $id))); ?>
<table>
<tr>
	<th>コース名</th>
	<td>
		<?php echo $this->Form->input("course_name", array('label' => false,'value' => $courses['Course']['course_name'], 'required' => 'true')); ?>
	</td>
</tr>
<tr>
	<th>概要</th>
	<td>
		<?php echo $this->Form->input("description", array('label' => false,'type' => 'textarea', 'value' => $courses['Course']['description'])); ?>
	</td>
</tr>
<tr>
	<th>タグ</th>
	<td>
		<div class="text_tag">
			<?php foreach ($tags as $tag): ?>
				<div class="tags"><?php echo $tag; ?><a class="delete"></a></div>
			<?php endforeach; ?>
			<input name="username" placeholder="type and enter" id="tag_list">
		</div>
	</td>
</tr>

<tr>
	<td></td>
	<td>
		<?php echo $this->Form->submit('Submit',array('label' => false, 'id' => 'btn_submit')); ?>
		<?php echo $this->Form->end(); ?>
	</td>
</tr>
</table>
</div>
<script type="text/javascript">	
	$(function(){
		var added_tags = [];
		var deleted_tags = [];
		
		$("#btn_submit").click(function(){
			var tags = [];
			$(".tags").each(function(){
				var text = $(this).text();
				// space white を削除
				text = $.trim(text);
				
				if(text.length>0){
					tags.push(text);
				}
			});
			if(added_tags.length>0 || deleted_tags.length>0){
				$.ajax({
					type : "POST",
					url : '<?php echo $this->base. "/courses/update_tag_course"; ?>',
					data : {tags:tags, deleted_tags:deleted_tags, course_id:<?php echo $id; ?>},
					success : function(res){
						if(res.message=="ok"){
							window.location = "<?php echo $this->Html->url(array('controller' => 'teachers', 'action' => 'view_a_course', $id)); ?>"
						}
					}
				});
			}
			return true;
		});
		
		/* enterボタンをdisableする */
		$(window).keydown(function(event){
		    if(event.keyCode == 13) {
		      event.preventDefault();
		      return false;
		    }
		  });
		
		/* タグを追加*/
		$(document).on("keydown",'#tag_list', function(e){
			if(e.keyCode==13){
				var text = $(this).val();
				text = $.trim(text);
				if(text.length>0){
					var tagObj = $('<div class="tags">' + text + '<a class="delete"></a></div>');
					tagObj.insertBefore($("#tag_list"));
					$("#tag_list").val('');
					added_tags.push(text);
				}
			}
		});

		/* 作成したタグを削除 */
		$(document).on('click','.delete', function(){
			var text = $(this).parent().text();
			$('#TeacherTags > option[value=' + text + ']').remove();
			deleted_tags.push(text);
			$(this).parent().remove();
		});
		$(document).on('click','.tags', function(){
			var text = $(this).text();
			deleted_tags.push(text);
			$(this).remove();
			$('#TeacherTags > option[value=' + text + ']').remove();			
		});
		
		$("#tag_list").autocomplete({
			source : function(req, res){
				$.ajax({
					url : "<?php echo $this->base.'/tags/key'?>",
					dataType : 'json',
					data : {term : req.term},
					success : function(data){
						if(data.length>0){
							// sau khi data la 1 mang cac object,thi ta phai
							// su dung ham $.map de chuyen no thanh dang array of items
							res($.map(data, function(item){
								return{
									label : item.Tag.tag_name,
									value : item.Tag.tag_name
								};
							}));
						}
					}
				});
			}			
		}); // end autocomplete
	});
</script>

<?php else: ?>

<?php echo "コースIDが既存しない"; ?>

<?php endif; ?>

<div class="actions">
	<ul>
		<li>
			<?php echo $this->Html->link( "コースリストを見る",   array('controller' => 'teachers', 'action'=>'view_list_course')); ?>
		</li>
		<li>
			<?php echo $this->Html->link( "コース作成",   array('controller' => 'teachers', 'action'=>'create_new_course')); ?>
		</li>
		<li>
			<?php echo $this->Html->link( "コース管理",   array('controller' => 'teachers', 'action'=>'course_manage', $id)); ?>
		</li>
		<li>
		<?php if($current_user): ?>
		<?php echo $this->Html->link( "ログアウト", array('controller' => 'teachers', 'action'=>'logout')); ?>
		<?php endif; ?>
		</li>
	</ul>
</div>
