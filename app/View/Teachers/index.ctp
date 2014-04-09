<style>
.main {
	margin-top: 50px;
}
#header_index{
	margin-bottom: 20px; 
}
</style>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<div class="row">
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-4">
					<img class="img-circle" style="width: 112px; height: 112px" src="<?php echo $this->base.UPLOAD_PROFILE_URL.'/'.$current_user['profile_img'];?>">
				</div>
				<div class="col-md-8">
					<h3><?php echo $current_user['full_name']; ?></h3>
					<address>
						<abbr title="Work email">メール:</abbr>
						<a href="mailto:#"><?php echo $current_user['email']; ?></a><br>
						
						<abbr title="phone">電話番号:</abbr>
						<?php echo $current_user['phone']; ?>
					</address>
				</div>
			</div>
			<div class="row" style="margin-top: 10px">
			<fieldset>
				<legend class="section">個人情報</legend>
			</fieldset>
			</div>
		</div>
	</div>
</div>
