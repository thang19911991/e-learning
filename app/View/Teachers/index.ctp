<style>
.main {
	margin-top: 50px;
}
</style>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<div class="row">
		<span class="label label-danger" style="font-size: 21px;" >先生としてユーザリスト</span>
		<?php if(!empty($users)): ?>
		<!-- table-responsive : để tương thích với màn hình bé hơn -->
		<div class="table-responsive">
		<table class="table table-hover table-bordered">
			<tr>
				<th>Id</th>
				<th>ユーザ名</th>
				<th>名前</th>
				<th>誕生日</th>
				<th>アドレス</th>
				<th>レベル</th>
			</tr>
			<?php foreach($users as $user): ?>
			<tr>
				<td><?php echo $user["User"]["id"]; ?></td>
				<td><?php echo $user["User"]["username"]; ?></td>
				<td><?php echo $user["User"]["full_name"]; ?></td>
				<td><?php echo $user["User"]["birthday"]; ?></td>
				<td><?php echo $user["User"]["address"]; ?></td>
				<td><?php echo $user["User"]["role"]; ?></td>
			</tr>
			<?php endforeach; ?>
		</table>
		<?php else:?>
		<?php echo "先生としてユーザが何かありません"; ?>
		<?php endif; ?>
		</div>
	</div>
</div>
