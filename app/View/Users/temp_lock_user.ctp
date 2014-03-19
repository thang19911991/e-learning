<style type="text/css">
#timer{
	margin-bottom: 10px;
	font-size: 20px;
}
</style>
<div class="row">
    <?php echo $this->Session->flash(); ?>
    <div class="col-md-8 col-md-offset-2">
	    <div class="jumbotron">
		  <h2>ユーザの仮ロック</h2>
		  <p><?php echo $total_lock_time; ?>秒 過ごしてからもう一度ログインできます</p>
		  <div id="timer" class="label label-danger"><?php echo $temp_lock_time; ?>秒 お待ちください</div>	
		</div>
	</div>
</div>
<script type="text/javascript">
	var sec = <?php echo $temp_lock_time; ?>;
	var timer = setInterval(function(){
		if(sec==0){
			clearInterval(timer);
			$(location).attr('href', "<?php	echo Router::url(array('controller' => 'users', 'action' => 'login')); ?>");
		}else{
			sec--;
			$("#timer").text(sec + "秒 お待ちください");
		}
	},1000);
</script>