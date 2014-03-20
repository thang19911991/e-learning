<style>
.main {
	margin-top: 50px;
}
</style>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<div class="row">
		<span class="label label-danger" style="font-size: 21px;" >コースリスト</span>
		<?php if(!empty($data)): ?>
		<!-- table-responsive : để tương thích với màn hình bé hơn -->
		<div class="table-responsive">
		<table class="table table-hover table-bordered">
			<tr>
				<th width="40%">授業名</th>
				<th width="20%">作成日</th>
				<th width="30%">作成者</th>
				<th width="10%">操作</th>
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
				<?php echo $this->Html->link( "編集", array (
					'div' => false,
					'url' => array(
						'controller' => 'teachers',
						'action' => 'edit_course',$course['Course']['id'] ))); ?>
				<?php echo $this->Html->link( "削除", array (
					'div' => false,
					'url' => array(
						'controller' => 'teachers',
						'action' => 'delete_course',$course['Course']['id'] ))); ?>
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