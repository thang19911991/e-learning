<style>
.main {
	margin-top: 50px;
}
</style>
<div class="col-sm-6 col-sm-offset-5 col-md-6 col-md-offset-2 main">
	<div class="row">
		<span class="label label-danger" style="font-size: 21px;" >プロファイル</span>
		<table class="table table-hover table-bordered">
			<tr>
				<td>ユーザ名</td>
				<td><?php echo $data['User']['username'];?></td>
			</tr>
			<tr>
				<td>名前</td>
				<td><?php echo $data['User']['full_name']; ?></td>
			</tr>
			<tr>
				<td>アドレス</td>
				<td><?php echo $data['User']['address'];?></td>
			</tr>
			<tr>
				<td>携帯電話番号</td>
				<td><?php echo $data['User']['phone'];?></td>
			</tr>
			<tr>
				<td>銀行アカウント</td>
				<td><?php echo $data['User']['credit_number']; ?></td>
			</tr>
			<tr>
				<td>メール</td>
				<td><?php echo $data['User']['email'];?></td>
			</tr>
		
			<tr>
				<td>誕生日</td>
				<td><?php echo $data['User']['birthday'];?></td>
			</tr>
		</table>
		<a class="btn btn-info" href="<?php echo $this->base.'/teachers/change_profile'?>">プロファイル変化</a>
		<a class="btn btn-primary" href="<?php echo $this->base.'/teachers/change_password'?>">パスワード変化</a>
		<a class="btn btn-success" href="<?php echo $this->base.'/teachers/change_secret_question'?>">秘密質問変化</a>
	</div>
</div>