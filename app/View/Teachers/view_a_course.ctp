<style>
.main {
	margin-top: 50px;
}
</style>
<div class="col-sm-9 col-sm-offset-5 col-md-9 col-md-offset-2 main">
	<div class="row">
		<?php if(!empty($courses)): ?>
		<span class="label label-danger" style="font-size: 21px;" >授業情報</span>
		<a style="float: right; margin-bottom: 5px" class="btn btn-warning" href="<?php echo $this->base.'/teachers/edit_course/'.$courses["Course"]["id"]?>">情報編集</a>		
		
		<!-- コース情報 -->
		<table class="table table-hover table-bordered">
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
		<span style="font-size: 21px" ><label>タグ</label></span>
		<table class="table table-hover table-bordered">
		<tr>
			<th>タグ名</th>
			<th style="width:25%">操作</th>
		</tr>
		<tr>
			<?php foreach ($courses['Tag'] as $tag): ?>
			<td><?php echo $tag['tag_name']; ?></td>
			<td>
				<a href="#" class="tag_name_edit btn btn-primary" id="<?php echo $tag['id']; ?>">編集</a>
				<a href="#" class="tag_name_delete btn btn-danger" id="<?php echo $tag['id']; ?>">削除</a>
			</td>
		</tr>
		<?php endforeach; ?>
		</table>
		<?php endif; ?>


		<!-- ドキュメント情報 -->
		<span style="font-size: 21px" ><label>ドキュメント</label></span>
		<a style="float: right; margin-bottom: 5px" class="btn btn-warning" href="<?php echo $this->base.'/documents/upload_new_document/'.$courses["Course"]["id"]?>">新アップロード</a>
		
		<table class="table table-hover table-bordered">
		<?php if(!empty($courses['Document'])) : ?>
		<tr>
			<th style="width:50%">ドキュメント名</th>
			<th>アップロード日</th>
			<th width="25%">操作</th>
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
				<a class="btn btn-primary" href="<?php echo $this->base.'/documents/reupload_document/'. $document['id']; ?>" class="test_name" id="<?php echo $document['id']; ?>">再アップロード</a>
				<a class="document_name btn btn-danger" id="<?php echo $document['id']; ?>">削除</a>
			</td>
		</tr>
			<?php endforeach; ?>
		<?php endif; ?>
		</table>		
		
		
		<!-- テスト情報 -->
		<span style="font-size: 21px" ><label>テスト</label></span>
		<a style="float: right; margin-bottom: 5px" class="btn btn-warning" href="<?php echo $this->base.'/tests/upload_new_test/'.$courses["Course"]["id"]?>">新アップロード</a>
		<table class="table table-hover table-bordered">
		<?php if(!empty($courses['Test'])) : ?>
		<tr>
			<th style="width:50%">テスト名</th>
			<th>アップロード日</th>
			<th width="25%">操作</th>
		</tr>
		<?php
				$tests = $courses['Test'];
					foreach ($tests as $test):
			?>
		<tr>
			<td>
				<?php echo $this->Html->link($test['name'], array('controller' =>'teachers', 'action' => 'update_link_document', $test['id']));; ?>		
			</td>
			<td>
				<?php echo $test['upload_date']; ?>
			</td>
			<td>
				<a class="btn btn-primary" href="<?php echo $this->base.'/tests/upload_new_test/'. $test['id']; ?>" class="test_name" id="<?php echo $test['id']; ?>">再アップロード</a>
				<a  href="#" class="test_name btn btn-danger" id="<?php echo $test['id']; ?>">削除</a>
			</td>
		</tr>
		<?php endforeach; ?>
		<?php endif; ?>
		</table>
		


		<!-- コメント情報 -->
		<?php if(!empty($courses['Comment'])) : ?>
		<span style="font-size: 21px" ><label>コメント</label></span>
		<table class="table table-hover table-borered">
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
				<a class="comment_name btn btn-danger" id="<?php echo $comment['id']; ?>">削除</a>
			</td>
		</tr>
		<?php endforeach; ?>
		</table>
		<?php endif; ?>
		
		
		<!-- コースIDが既存しない場合 -->
		<?php else: ?>
		<span class="label label-danger" style="font-size: 20px"><?php echo "そのコースIDが既存しない";?></span>
		<?php endif; ?>
	</div>
</div>


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