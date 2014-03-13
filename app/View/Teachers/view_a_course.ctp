<div class="index">
<?php if(!empty($courses)): ?>


<!-- コース情報 -->
<div class="actions">
	<h2><label>コース情報</label></h2>
</div>
<span style="float: right; margin-top: 20px" class="actions">
<?php echo $this->Html->link('情報編集', array('controller' => 'teachers', 'action' => 'edit_course',$courses['Course']['id'])); ?>
</span>
<table>
<tr>
	<td>コース名</td>
	<td>作成者</td>
	<td>作成日</td>
	<td>「いいね」数</td>
	<td>概要</td>
</tr>
<tr>
	<td><?php echo $courses['Course']['course_name']; ?></td>
	<td><?php echo $courses['Teacher']['User']['username']; ?></td>
	<td><?php echo $courses['Course']['created_date']; ?></td>
	<td><?php echo $course_like_count; ?></td>
	<td><?php echo $courses['Course']['description']; ?></td>
</tr>
</table>





<!-- タグ情報 -->
<?php if(!empty($courses['Tag'])) : ?>
<div class="actions"><h2><label>タグ</label></h2></div>
<table>
<tr>
	<th>タグ名</th>
	<th style="width:50%">操作</th>
</tr>
<tr>
	<?php foreach ($courses['Tag'] as $tag): ?>
	<td><?php echo $tag['tag_name']; ?></td>
	<td>
		<a href="#" class="tag_name_edit" id="<?php echo $tag['id']; ?>">編集</a>
		<a href="#" class="tag_name_delete" id="<?php echo $tag['id']; ?>">削除</a>
	</td>
</tr>
<?php endforeach; ?>
</table>
<?php endif; ?>



<!-- ドキュメント情報 -->
<?php if(!empty($courses['Document'])) : ?>
<div class="actions"><h2 style="font-size: 24px;"><label>ドキュメント</label></h2></div>
<span style="float: right; margin-top: 20px" class="actions">
<?php echo $this->Html->link('新アップロード', array('controller' => 'documents', 'action' => 'upload_new_document',$courses['Course']['id'])); ?>
</span>
<table>
<tr>
	<th style="width:50%">ドキュメント名</th>
	<th>アップロード日</th>
	<th>操作</th>
</tr>
<?php
	$documents = $courses['Document'];
	foreach ($documents as $document):
?>
<tr>	
	<td>
		<?php echo $this->Html->link($document['name'], array('controller' =>'teachers', 'action' => 'update_link_document', $document['id']));; ?>		
	</td>
	<td>
		<?php echo $document['upload_date']; ?>
	</td>
	<td>
		<?php echo $this->Html->link("再アップロード", array('controller' => 'documents', 'action' => 'reupload_document', $document['id'])); ?>
		<a href="" class="document_name" id="<?php echo $document['id']; ?>">削除</a>
	</td>
</tr>
	<?php endforeach; ?>
</table>
<?php endif; ?>

<!-- テスト情報 -->
<?php if(!empty($courses['Test'])) : ?>
<div class="actions"><h2><label>テスト</label></h2></div>
<span style="float: right; margin-top: 20px" class="actions">
<?php echo $this->Html->link('新アップロード', array('controller' => 'tests', 'action' => 'upload_new_test',$courses['Course']['id'])); ?>
</span>
<table>
<tr>
	<th style="width:50%">テスト名</th>
	<th>アップロード日</th>
	<th>操作</th>
</tr>
<tr>	
	<?php
		$tests = $courses['Test'];
			foreach ($tests as $test):
	?>
	<td>
		<?php echo $this->Html->link($test['name'], array('controller' =>'teachers', 'action' => 'update_link_document', $test['id']));; ?>		
	</td>
	<td>
		<?php echo $test['upload_date']; ?>
	</td>
	<td>
		<?php echo $this->Html->link("再アップロード", array('controller' => 'tests', 'action' => 'upload_new_test', $test['id'])); ?>
		<a href="#" class="test_name" id="<?php echo $test['id']; ?>">削除</a>
	</td>
	<?php endforeach; ?>
</tr>
</table>
<?php endif; ?>

<!-- コメント情報 -->
<?php if(!empty($courses['Comment'])) : ?>
<div class="actions"><h2><label>コメント</label></h2></div>
<table>
<tr>
	<th style="width:50%">作成者</th>
	<th>投稿日</th>
	<th>操作</th>
</tr>
<?php
		$comments = $courses['Comment'];
		foreach ($comments as $comment):
?>
<tr>	
	<td><?php echo $comment['User']['username']; ?></td>
	<td><?php echo $comment['content']; ?></td>
	<td>
		<a href="" class="comment_name" id="<?php echo $comment['id']; ?>">削除</a>
	</td>
</tr>
<?php endforeach; ?>
</table>
<?php endif; ?>

<script type="text/javascript">
	$(function(){
		$(".tag_name_edit").click(function(){
			var id = $(this).attr("id");
			var data = prompt("そのタグを入力してください");
			if(data!=null){
				$.ajax({
					type : 'POST',
					url  : "<?php echo $this->base.'/tags/edit_tag'; ?>",
					data : {tag_id:id, content:data},
					success : function(res){
						if(res=="ok"){
							window.location = "<?php echo $this->Html->url(array('controller' => 'teachers', 'action' => 'view_a_course', $course_id)); ?>"
						}
					}
				});
				return true;
			}else{
				return false;
			}
		});

		$(".tag_name_delete").click(function(){
			var course_id = '<?php echo $courses['Course']['id']; ?>';
			var id = $(this).attr("id");
			var check = confirm("そのタグが削除したいですか？");
			if(check==true){
				$.ajax({
					type : 'POST',
					url  : "<?php echo $this->base.'/tags/delete_tag'; ?>",
					data : {tag_id:id, course_id:course_id},
					success : function(res){
						if(res=="ok"){
							window.location = "<?php echo $this->Html->url(array('controller' => 'teachers', 'action' => 'view_a_course', $course_id)); ?>"
						}
					}
				});
				return true;
			}else{
				return false;
			}
		});
		
		$(".document_name").click(function(){
			var id = $(this).attr("id");
			var check = confirm("そのドキュメントが削除したいですか？");
			if(check==true){
				$.ajax({
					type : 'POST',
					url  : "<?php echo $this->base.'/documents/delete_document'; ?>",
					data : {document_id:id},
					success : function(res){
						if(res=="ok"){
							window.location = "<?php echo $this->Html->url(array('controller' => 'teachers', 'action' => 'view_a_course', $course_id)); ?>"
						}
					}
				});
				return true;
			}else{
				return false;
			}
		});

		$(".test_name").click(function(){
			var id = $(this).attr("id");
			var check = confirm("そのテストが削除したいですか？");
			
			if(check==true){
				$.ajax({
					type : 'POST',
					url  : "<?php echo $this->base.'/tests/delete_test'; ?>",
					data : {test_id:id},
					success : function(res){
						if(res=="ok"){
							window.location = "<?php echo $this->Html->url(array('controller' => 'teachers', 'action' => 'view_a_course', $course_id)); ?>"
						}
					}
				});
				return true;
			}else{
				return false;
			}
		});

		$(".comment_name").click(function(){
			var id = $(this).attr("id");
			var check = confirm("そのコメントが削除したいですか？");
			if(check==true){
				$.ajax({
					type : 'POST',
					url  : "<?php echo $this->base.'/comments/delete_comment'; ?>",
					data : {comment_id:id},
					success : function(res){
						if(res=="ok"){
							window.location = "<?php echo $this->Html->url(array('controller' => 'teachers', 'action' => 'view_a_course', $course_id)); ?>"
						}
					}
				});
				return true;
			}else{
				return false;
			}
		});
	});
</script>

<!-- メニューを表す -->
</div>
<div class="actions">
	<ul>
		<li>
			<?php echo $this->Html->link( "コースリストを見る",   array('controller' => 'teachers', 'action'=>'view_list_course')); ?>
		</li>
		<li>
			<?php echo $this->Html->link( "コース編集",   array('controller' => 'teachers', 'action'=>'edit_course',$id)); ?>
		</li>
		<li>
			<?php echo $this->Html->link( "コース作成",   array('controller' => 'teachers', 'action'=>'create_new_course')); ?>
		</li>
		<li>
			<?php echo $this->Html->link( "コースの学生管理",   array('controller' => 'teachers', 'action'=>'course_manage', $courses['Course']['id'])); ?>
		</li>
		<li>
		<?php if($current_user): ?>
		<?php echo $this->Html->link( "ログアウト", array('controller' => 'teachers', 'action'=>'logout')); ?>
		<?php endif; ?>
		</li>
	</ul>
</div>

<!-- nếu như course không tồn tại -->
<?php else: ?>
<?php echo "そのコース名が既存しない";?>
<?php endif; ?>