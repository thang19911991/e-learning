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

echo $this->fetch('meta');
echo $this->fetch('css');
echo $this->fetch('script');
?>

<style type="text/css">

.carousel-inner > .item > img, .carousel-inner > .item > a > img {
	min-width:100%;
}

/* custome cái carousel để set màu sắc, chiều cao */
.item{ 
	background-color: black;
	text-align: center; 
	color: white;
	line-height: 300px; 
	height: 292px; 
	font-size: 50px;
}

/* HEADER */
#header{
	margin-bottom: 20px;
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
	<div class="navbar navbar-inverse">
		<div class="container">
			<!-- data-target là để tham chiếu đến cái class = navbar-collapse -->
			<button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<!-- các thẻ span này là để hiển thị các nét gạch trong cái button -->
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="" class="navbar-brand">E-learning</a>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav navbar-left">
					<li class="active"><a href="#">Home</a></li>
					<li><a href="#">Contact</a></li>
					<li><a href="#">About</a></li>
					<li><a href="#">Subject</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">More<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="#">Action 1</a></li>
							<li><a href="#">Action 2</a></li>
							<li><a href="#">Action 3</a></li>
							<li><a href="#">Action 4</a></li>
							<li><a href="#">Action 5</a></li>
						</ul>
					</li>
				</ul>				
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
				<form class="navbar-form navbar-right">
            		<input type="text" class="form-control" placeholder="Search...">
          		</form>
			</div>
		</div>
	</div><!-- END MENU AREA -->
	
	
	<!-- HEADER AREA -->
	<div class="container" id="header">
		<div class="row">
			<!-- CAROUSEL AREA -->
			<div class="col-md-12">
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
							<img src="/cake/img/EFK_slider_home_1.jpg" alt="post image">
						</div>
			            <div class="item">
							<img src="/cake/img/EFK_slider_home_2.jpg" alt="post image">
						</div>
			            <div class="item">
			            	<img src="/cake/img/EFK_slider_home_3.jpg" alt="post image">
						</div>
						<div class="item">
			            	<img src="/cake/img/EFK_slider_home_4.jpg" alt="post image">
						</div>
					</div>
					
					<!-- Carousel nav -->
					<a href="#myCarousel" class="left carousel-control" data-slide="prev"><span class="icon-prev"></span></a>
					<a href="#myCarousel" class="right carousel-control" data-slide="next"><span class="icon-next"></span></a>
				</div>
			</div><!-- END CAROUSEL AREA -->
		</div>
	</div><!-- END HEADER AREA -->
	
	
	
	<!-- CONTENT AREA -->
	<div class="container">
		<?php echo $this->fetch('content'); ?>
	</div>
	
	<!-- FOOTER AREA -->
    <footer class="footer">
      <div class="container">
        <p>Designed and built with all the love in the world by <a href="http://twitter.com/mdo" target="_blank">@mdo</a> and <a href="http://twitter.com/fat" target="_blank">@fat</a>.</p>
        <p>Code licensed under <a href="http://www.apache.org/licenses/LICENSE-2.0" target="_blank">Apache License v2.0</a>, documentation under <a href="http://creativecommons.org/licenses/by/3.0/">CC BY 3.0</a>.</p>
        <p><a href="http://glyphicons.com">Glyphicons Free</a> licensed under <a href="http://creativecommons.org/licenses/by/3.0/">CC BY 3.0</a>.</p>
        <ul class="footer-links">
          <li><a href="http://blog.getbootstrap.com">Blog</a></li>
          <li class="muted">&middot;</li>
          <li><a href="https://github.com/twbs/bootstrap/issues?state=open">Issues</a></li>
          <li class="muted">&middot;</li>
          <li><a href="https://github.com/twbs/bootstrap/releases">Changelog</a></li>
        </ul>
      </div>
    </footer>
	
	<!-- Placed at the end of the document so the pages load faster -->
	<?php echo $this->Html->script('jquery.min'); ?>
	<?php echo $this->Html->script('bootstrap.min'); ?>
	<?php //echo $this->element('sql_dump'); ?>
</body>
</html>