<style>
.main {
	margin-top: 50px;
}
</style>
<div class="col-sm-8 col-sm-offset-3 col-md-9 col-md-offset-2 main">
	<div class="row">
		<span class="label label-danger" style="font-size: 21px;" >コースリスト</span>
		<?php if(!empty($data)): ?>
		<!-- table-responsive : để tương thích với màn hình bé hơn -->
		<div class="table-responsive">
		<table class="table table-hover table-bordered">
			<tr>
				<th>授業名</th>
				<th>作成日</th>
				<th>作成者</th>
				<th width="15%">操作</th>
			</tr>
			<?php foreach ($data as $course ): ?>
			<tr>
				<td><?php echo $this->Html->link($course['Course']['course_name'], array (
						'controller' => 'teachers',
						'action' => 'view_a_course',$course['Course']['id'] )); ?>
				</td>
				<td><?php echo $course['Course']['created_date']; ?></td>
				<td><?php echo $course['User']['username']; ?></td>
				<td>
				<a class='btn btn-primary' href="<?php echo $this->base.'/teachers/edit_course/'.$course['Course']['id']; ?>">編集</a>
				<a class='delete_course btn btn-danger' href="<?php echo $this->base.'/teachers/delete_course/'.$course['Course']['id']; ?>">削除</a>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
		</div>
		<?php else: ?>
		<?php echo "その先生がコースが何かありません"; ?>
		<?php endif; ?>
	</div>
</div>
<script type="text/javascript">	
	$(function(){		
		$(".delete_course").click(function(){
			var data = confirm("その授業が削除したいですか？");
			if(data==true){
				return true;
			}else{
				return false;
			}
		});
		
	});
</script>