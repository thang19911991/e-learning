<style>
.main {
	margin-top: 50px;
}
</style>
<div class="col-sm-6 col-sm-offset-5 col-md-6 col-md-offset-2 main">
	<div class="row">
		<span class="label label-danger" style="font-size: 21px;" >授業情報変化</span>
		<?php if(!empty($courses)): ?>
		<?php $tags = array(); ?>
		<?php foreach($courses['Tag'] as $t): ?>
			<?php  $tags[] = $t['tag_name']; ?>
		<?php endforeach;?>		
		
		<?php echo $this->Form->create("Course", array(
			'url' => array('controller' => 'teachers', 'action' => 'edit_course', $id),
			'class' => 'well',
			'inputDefaults' => array(
				'div' => false,
				'label' => false,
				'class' => 'form-control'
			)
		)); ?>
		
		<div class="form-group">
			<label>コース名</label>
			<?php echo $this->Form->input("course_name", array(
				'value' => $courses['Course']['course_name'], 'required' => 'false'));
			?>
		</div>
		
		<div class="form-group">
			<label for="description">概要</label><br>
			<?php echo $this->Form->textarea("description", array(
					'class' => 'form-control',
					'rows' => 10,
					'cols' => 50,
					'value' => $courses['Course']['description'], 
					'required' => 'false'
			));?>
		</div>
		
		<div class="form-group">
			<label>タグ</label>
			<div class="text_tag">
				<?php foreach ($tags as $tag): ?>
					<div class="tags"><?php echo $tag; ?><a class="delete"></a></div>
				<?php endforeach; ?>
				<?php echo $this->Form->input("username", array(
						'class' => 'form-control',
						'placeholder' => 'type and enter',
						'id' => 'tag_list'
					));
				?>
			</div>
		</div>
		<?php echo $this->Form->submit('Submit',array(
			'class' => 'btn btn-primary',
			'label' => false, 
			'id' => 'btn_submit')); ?>
		<?php echo $this->Form->end(); ?>
		
		<?php else: ?>
		<?php echo "コースIDが既存しない"; ?>
		<?php endif; ?>
	</div>
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

