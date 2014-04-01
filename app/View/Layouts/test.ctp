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
			<a href="#" class="navbar-brand">E-learning</a>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav navbar-left">
					<li class="active"><a href="<?php echo $this->base.'/home/index'; ?>">Home</a></li>
					<li><a href="#">Projects</a></li>
					<li><a href="#">Services</a></li>
					<li><a href="#">About</a></li>
					<li><a href="#">Contact</a></li>
				</ul>
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
			 	  <ul class="nav nav-sidebar">
		            <li class="active"><a href="#">Overview</a></li>
		            <li><a href="#">Reports</a></li>
		            <li><a href="#">Analytics</a></li>
		            <li><a href="#">Export</a></li>
		          </ul>
		          <ul class="nav nav-sidebar">
		            <li><a href="">Nav item</a></li>
		            <li><a href="">Nav item again</a></li>
		            <li><a href="">One more nav</a></li>
		            <li><a href="">Another nav item</a></li>
		            <li><a href="">More navigation</a></li>
		          </ul>
		          <ul class="nav nav-sidebar">
		            <li><a href="">Nav item again</a></li>
		            <li><a href="">One more nav</a></li>
		            <li><a href="">Another nav item</a></li>
		          </ul>
			</div><!-- MENU ACTION AREA -->
						
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				<div class="row">
					<!-- CAROUSEL AREA -->
					<div id="myCarousel" class="carousel slide" data-ride="carousel">
						<!-- Indicators -->
						<ol class="carousel-indicators">
							<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
							<li data-target="#myCarousel" data-slide-to="1"></li>
							<li data-target="#myCarousel" data-slide-to="2"></li>
							<li data-target="#myCarousel" data-slide-to="3"></li>
						</ol>
						
						<!-- Carousel Items -->
						<div class="carousel-inner">
							<div class="item active">
								<img src="<?php echo $this->base.'/img/EFK_slider_home_1.jpg'; ?>" alt="post image">
							</div>
				            <div class="item">
								<img src="<?php echo $this->base.'/img/EFK_slider_home_2.jpg'; ?>" alt="post image">
							</div>
				            <div class="item">
				            	<img src="<?php echo $this->base.'/img/EFK_slider_home_3.jpg'; ?>" alt="post image">
							</div>
							<div class="item">
				            	<img src="<?php echo $this->base.'/img/EFK_slider_home_4.jpg'; ?>" alt="post image">
							</div>
						</div>
						
						<!-- Carousel nav -->
						<a href="#myCarousel" class="left carousel-control" data-slide="prev"><span class="icon-prev"></span></a>
						<a href="#myCarousel" class="right carousel-control" data-slide="next"><span class="icon-next"></span></a>
					</div><!-- END CAROUSEL AREA -->
				</div>
				
				<div class="row">
				<!-- CONTENT AREA -->
				<div class="row content">
					<?php echo $this->Session->flash(); ?>
					<?php echo $this->fetch('content'); ?>
				</div><!-- END CONTENT AREA -->
				</div>
			</div>
		</div>
	</div><!-- END BODY AREA -->
	
	<!-- Placed at the end of the document so the pages load faster -->
	<?php echo $this->Html->script('jquery.min'); ?>
	<?php echo $this->Html->script('bootstrap.min'); ?>
	<?php //echo $this->element('sql_dump'); ?>
</body>
</html>