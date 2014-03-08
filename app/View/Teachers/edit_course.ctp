<div class="index">
<h2>コース情報変化</h2>
<?php $tags = array(); ?>
<?php foreach($courses[0]['Tag'] as $t): ?>
	<?php  $tags[] = $t['tag_name']; ?>
<?php endforeach;?>

<?php echo $this->Form->create(null, array('url' => array('controller' => 'teachers', 'action' => 'edit_course', $id))); ?>
<table>
<tr>	
	<td><h3><label for="course_name">授業名</label></h3></td>
	<td>
		<?php echo $this->Form->input('course_name',array('required' => 'false', 'label' => false,'value' => $courses[0]['Course']['course_name'])); ?>		
	</td>
</tr>
<tr>
	<td><h3><label for="tag">タグ</label></h3></td>
	<td>		
		<div class="text_tag">
			<?php foreach ($tags as $tag): ?>
				<div class="tags"><?php echo $tag; ?><a class="delete"></a></div>
			<?php endforeach; ?>
			<input type="text" placeholder="Type & Enter" id="tag_list"/>
			<select name="data[Teacher][tags]" id="TeacherTags">
			<?php foreach ($tags as $tag): ?>				
				<option value="<?php echo $tag; ?>"><?php echo $tag; ?></option>
			<?php endforeach; ?>
			</select>
			
			
		</div>
		<?php echo $this->Form->select('select', $tags, array('value' => 1)); ?>
	</td>
</tr>
<tr>
	<td><h3><label for="description">概要</label></h3></td>
	<td>
		<?php echo $this->Form->input('description',array('required' => 'false', 'label' => false, 'value' => $courses[0]['Course']['description'])); ?>		
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
		$("#tag_list").autocomplete({
			source : function(req, res){
				$.ajax({
					url : "<?php echo $this->base.'/teachers/key'?>",
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
<div class="actions">
	<ul>
		<li>
			<?php echo $this->Html->link( "コースリストを見る",   array('controller' => 'teachers', 'action'=>'show_courses')); ?>
		</li>
		<li>
			<?php echo $this->Html->link( "コース作成",   array('controller' => 'teachers', 'action'=>'add_course')); ?>
		</li>
		<li>
		<?php if($current_user): ?>
		<?php echo $this->Html->link( "ログアウト", array('controller' => 'teachers', 'action'=>'logout')); ?>
		<?php endif; ?>
		</li>
	</ul>
</div>
