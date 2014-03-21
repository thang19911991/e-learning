<!DOCTYPE html>
<html>
<head>
<meta charset="utf8">
<title><?php echo $title_for_layout; ?>
</title>
<?php
//echo $this->Html->css('cake.generic');
//echo $this->Html->css('bootstrap-theme.min');
echo $this->Html->css('bootstrap.min');
echo $this->Html->css('teacher');
echo $this->Html->script('jquery.min');

echo $this->fetch('meta');
echo $this->fetch('css');
echo $this->fetch('script');
?>

<style type="text/css">
/* nếu menu set là navbar-fixed-top thì thuộc tính margin-bottom sẽ không có ý nghĩa*/
.carousel{
	margin-top: 60px;
}
/*
 * Sidebar
 */

/* Hide for mobile, show later */
.sidebar {
  display: none;
}
@media (min-width: 768px) {
  .sidebar {
    position: fixed;
    top: 51px;
    bottom: 0;
    left: 0;
    z-index: 1000;
    display: block;
    padding: 20px;
    overflow-x: hidden;
    overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
    background-color: #f5f5f5;
    border-right: 1px solid #eee;
  }
}

/* Sidebar navigation */
.nav-sidebar {
  margin-right: -21px; /* 20px padding + 1px border */
  margin-bottom: 20px;
  margin-left: -20px;
}
.nav-sidebar > li > a {
  padding-right: 20px;
  padding-left: 20px;
}
.nav-sidebar > .active > a {
  color: #fff;
  background-color: #428bca;
}

/*
 * Main
 */
.main{
	padding: 20px;
}

@media (min-width: 768px) {
  .main {
    padding-right: 40px;
    padding-left: 40px;
  }
}
.main .page-header {
  margin-top: 0;
}

/*
 * Main
 */
.content{
	margin-top: 20px;
}


/* Footer 
-------------------------------------------------- */
.footer {
  margin-top: 50px;
  text-align: center;
  padding: 30px 0;  
  border-top: 1px solid #e5e5e5;
  background-color: #f5f5f5;
}
.footer p {
  margin-bottom: 0;
  color: #777;
}
.footer-links {
  margin: 10px 0;
}
.footer-links li {
  display: inline;
  padding: 0 2px;
}
.footer-links li:first-child {
  padding-left: 0;
}

</style>
</head>
<body>
	<!-- MENU AREA -->
	<div class="nav navbar-inverse navbar-fixed-top" id="menu">
		<div class="container">
			<button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="<?php echo $this->base.'/home/index'?>" class="navbar-brand">E-learning</a>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav navbar-left">
					<li class="active">
						<?php if(!empty($current_user) && $current_user['role']=="student"):?>
						<a href="<?php echo $this->base.'/student/std_index'?>">ホームページ</a>
						<?php endif; ?>
						
						<?php if(!empty($current_user) && $current_user['role']=="teacher"):?>
						<a href="<?php echo $this->base.'/teachers/index'?>">ホームページ</a>
						<?php endif; ?>
					</li>
					<li><a href="#">Projects</a></li>
					<li><a href="#">Services</a></li>
					<li><a href="#">About</a></li>
					<li><a href="#">Contact</a></li>
				</ul>
				<?php if(empty($current_user)):?>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Register<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $this->base.'/student/std_register'; ?>">Student</a></li>
							<li><a href="<?php echo $this->base.'/teachers/register'; ?>">Teacher</a></li>
						</ul>
					</li>
					<li><a href="<?php echo $this->base.'/users/login'; ?>">Sign Up</a></li>
				</ul>
				<?php else: ?>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $current_user['username']; ?><b class="caret"></b></a>
						<ul class="dropdown-menu">
							<?php if($current_user['role']==User::STUDENT):?>
							<li><a href="<?php echo $this->base.'/student/std_profile'; ?>">アカウント情報</a></li>
							<?php elseif($current_user['role']==User::TEACHER):?>
							<li><a href="<?php echo $this->base.'/teachers/view_profile'; ?>">アカウント情報</a></li>
							<?php endif; ?>
							<li><a href="<?php echo $this->base.'/users/logout'; ?>">ログアウト</a></li>
						</ul>
					</li>
				</ul>
				<?php endif; ?>
				<form class="navbar-form navbar-right">
					<input class="form-control" type="text" placeholder="Search">
				</form>
			</div>
		</div>
	</div><!-- END MENU AREA -->
			
	
	<!-- BODY AREA -->
	<div class="container-fluid">
		<div class="row">
			<!-- MENU ACTION AREA -->
			<div class="col-sm-3 col-md-2 sidebar">
			 	  <?php $this->Teacher->leftMenu(); ?>
			</div><!-- MENU ACTION AREA -->
			
			<!-- CONTENT AREA -->
			<?php echo $this->fetch('content'); ?>
			<!-- END CONTENT AREA -->
		</div>
	</div><!-- END BODY AREA -->
	
	<!-- Placed at the end of the document so the pages load faster -->
	<?php echo $this->Html->script('bootstrap.min'); ?>
	<?php //echo $this->element('sql_dump'); ?>
</body>
</html>