<?php 
	$cakeDescription = __d('cake_dev', 'Chat');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->css('chat_style.css');
		echo $this->Html->script("jquery-1.7.2-min");
		
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>	
	<div id="header">
		<?php echo $this->Html->link("Return the Dashboard",array('controller' => 'users','action' => 'index'),array('id' => 'home')); ?>
		<?php echo $this->Html->link("Logout",array('controller' => 'users','action' => 'logout'),array('id' => 'logout')); ?>
	</div>
	<div id="wrapper">
		<div id="left">
			<div id="room_name">CHAT ROOMS</div>
			<div id="show_room">
				<?php if(count($threads)>0):?>
					<ul>
						<?php foreach ($threads as $thread): ?>
							<?php if($thread['Thread']['id']==$id):?>
								<li class="active"><?php echo $this->Html->link($thread['Thread']['thread_name'],array('controller' => 'threads', 'action' => 'view', $thread['Thread']['id'])); ?></li>
							<?php else:?>
								<li><?php echo $this->Html->link($thread['Thread']['thread_name'],array('controller' => 'threads', 'action' => 'view', $thread['Thread']['id'])); ?></li>
							<?php endif;?>
						<?php endforeach; ?>
					</ul>
				<?php endif;?>
			</div>
		</div>
		<div id="main">
			<?php echo $this->Session->flash(); ?>
			<div id="chat_window">
					<div id="chat_view">
						<?php echo $this->fetch('content'); ?>
						<!-- <div id="message_left" class="message" title="toi di hoc">thang1991 : toi di hoc</div>
						<div id="message_right" class="message">hom nay hoc gi the</div>
						<div id="message_left" class="message">tao khong biet</div>  --> 
					</div>
					<div id="chat_box">
						<input type="text" id="content_chat">
					</div>
			</div>
		</div>
		
		<?php //echo $this->Html->image('edit.png', array('title'=>'Edit','width' => '28px','height' => '28px')); ?>
		<script type="text/javascript">
		
		// luu doi tuong jQuery #chat_view vao bien $chat_view
		var $chat_view = $("#chat_view");
		$(function(){
			function getScrollHeight(){
				var height = $chat_view.prop("scrollHeight");
				return height;
			}
						
			function scroll(oldHeight, newHeight){
				if(newHeight > oldHeight ){
					$chat_view.animate({scrollTop : newHeight},"slow");
				}
			}

			// khi hover qua thì sẽ hiện ra cái menu : edit, delete
			$("div.message").hover(function(){
				$(this).append("<div class=\"actions\"><img title=\"edit\" src=\"../img/edit.png\" width=\"28px\" height=\"28px\"><img title=\"delete\" src=\"../img/delete.png\" width=\"28px\" height=\"28px\"></div>");
			},function(){
				$(this).find("div.actions:last").remove();
			});

			$("#show_room ul li").click(function(){
				loadComment();
			});
			
			$("#content_chat").on('keypress',function(event){
				if(event.keyCode==13){
					var content = $("#content_chat").val();
					if(content.length>0){
						var oldHeight = getScrollHeight();
						$.ajax({
							type 	: "POST",
							url 	: "<?php echo Router::url(array('controller' => 'messages', 'action' =>'add'), true); ?>",
							data 	: {message : content, thread_id : <?php echo $id; ?>, user_id : <?php echo $user_id; ?>},
							success : function(data){
								if(data.length>0){
									$("#content_chat").val("");
									$chat_view.append(data);
									var newHeight = getScrollHeight();
									scroll(oldHeight, newHeight);
								}
							}
						});
					}
				}
			});

			// load comment của ng post trong threads
			function loadComment(){
				var oldHeight = getScrollHeight();
					
				$.ajax({
					type : "POST",
					url  : "<?php echo Router::url(array('controller' => 'messages', 'action' => 'load_message'), true); ?>",
					data : {thread_id : <?php echo $id; ?>, user_id : <?php echo $user_id; ?>},
					success : function(data){
						if(data.length>0){
							$chat_view.html(data);
							var newHeight = getScrollHeight();
							scroll(oldHeight, newHeight);
						}
					}
				});
			}
			setInterval(loadComment, 1000);
		});
		</script>
	</div>
</body>
</html>
