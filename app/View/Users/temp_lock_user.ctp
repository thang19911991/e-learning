<div class="index">
<h2>Lock Temp User</h2>
<a id="timer"><?php echo $temp_lock_time; ?>秒</a>

<script type="text/javascript">
	var sec = <?php echo $temp_lock_time; ?>;
	var timer = setInterval(function(){
		if(sec==0){
			clearInterval(timer);
			$(location).attr('href', "<?php	echo Router::url(array('controller' => 'users', 'action' => 'login')); ?>");
		}else{
			sec--;
			$("#timer").text(sec + "秒");
		}
	},1000);
</script>
</div>