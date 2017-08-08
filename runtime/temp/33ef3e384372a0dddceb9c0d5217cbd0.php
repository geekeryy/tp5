<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:90:"H:\Git\phpproject\thinkphp_5.0.10_full\public/../application/index\view\index\contact.html";i:1502170224;s:89:"H:\Git\phpproject\thinkphp_5.0.10_full\public/../application/index\view\include\head.html";i:1502170225;s:90:"H:\Git\phpproject\thinkphp_5.0.10_full\public/../application/index\view\include\aside.html";i:1502170226;s:91:"H:\Git\phpproject\thinkphp_5.0.10_full\public/../application/index\view\include\footer.html";i:1502170225;}*/ ?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
	
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>comeonjy</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="江杨" />
	<meta name="keywords" content="" />
	

  

  	<!-- Facebook and Twitter integration -->
	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<link rel="shortcut icon" href="favicon.ico">

	<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,600,400italic,700' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	
	<!-- Animate.css -->
	<link rel="stylesheet" href="__static__/css/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="__static__/css/icomoon.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="__static__/css/bootstrap.css">
	<!-- Owl Carousel -->
	<link rel="stylesheet" href="__static__/css/owl.carousel.min.css">
	<link rel="stylesheet" href="__static__/css/owl.theme.default.min.css">
	<!-- Theme style  -->
	<link rel="stylesheet" href="__static__/css/style.css">
	
	<script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp"></script>
	<script type="text/javascript" src="https://3gimg.qq.com/lightmap/components/geolocation/geolocation.min.js"></script>

	<!-- Modernizr JS -->
	<script src="__static__/js/modernizr-2.6.2.min.js"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
	<![endif]-->



	</head>
	<body onload="init()">

	<div id="fh5co-page">
		<a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle dark"><i></i></a>
		<aside id="fh5co-aside" role="complementary" class="border js-fullheight">

			<h1 id="fh5co-logo"><a href="index.html"><img <?php echo logo(\think\Session::get('info.figureurl_qq_2')); ?> alt="Free HTML5 Bootstrap Website Template" style="border-radius:50px"></a></h1>
			<nav id="fh5co-main-menu" role="navigation">
				<ul>
<!-- 					<li <?php echo aside($page,'index'); ?> ><a href="<?php echo url('index/index'); ?>">主页</a></li>
					<li <?php echo aside($page,'portfolio'); ?> ><a href="<?php echo url('index/portfolio'); ?>">作品</a></li>
					<li <?php echo aside($page,'about'); ?> ><a href="<?php echo url('index/about'); ?>">关于</a></li> -->
					<li <?php echo aside($page,'contact'); ?> ><a href="<?php echo url('index/contact'); ?>">联系</a></li>
					<li <?php echo aside($page,'test'); ?> ><a href="<?php echo url('index/test'); ?>">地图Demo</a></li>
					<li <?php echo aside($page,'session'); ?> ><a href="<?php echo url('main/session'); ?>">session</a></li>
					<li <?php echo aside($page,'test2'); ?> ><a href="<?php echo url('index/test2'); ?>">test2</a></li>
					<li <?php echo aside($page,'phonereg'); ?> ><a href="<?php echo url('index/phonereg'); ?>">手机注册</a></li>
					<li <?php echo aside($page,'mailreg'); ?> ><a href="<?php echo url('index/mailreg'); ?>">邮箱注册</a></li>
					<li <?php echo aside($page,'register'); ?> ><a href="<?php echo url('index/register'); ?>">账号注册</a></li>
					<li <?php echo aside($page,'bindphone'); ?> ><a href="<?php echo url('index/bindphone'); ?>">bindphone</a></li>
					<li <?php echo aside($page,'bindmail'); ?> ><a href="<?php echo url('index/bindmail'); ?>">bindmail</a></li>
				</ul>
			</nav>

			<div class="fh5co-footer">
				<p><span>您好，欢迎来到我的个人网站</span><small>&copy; 2016 . All Rights Rerved.</small></p>
				<ul>
					<li><a href="<?php echo url('Oauth/qq_login'); ?>"><i class="icon-qq"></i></a></li>
					<li><a href="#"><i class="icon-weibo"></i></a></li>
					<li><a href="#"><i class="icon-weixin"></i></a></li>
				</ul>
			</div>

		</aside>

		<div id="fh5co-main">

			<div id="map"></div>
		
			<div class="fh5co-more-contact">
				<div class="fh5co-narrow-content">
					<div class="row">
						<div class="col-md-4">
							<div class="fh5co-feature fh5co-feature-sm animate-box" data-animate-effect="fadeInLeft">
								<div class="fh5co-icon">
									<i class="icon-envelope-o"></i>
								</div>
								<div class="fh5co-text">
									<p><a href="mailto:1126254578@qq.com">1126254578@qq.com</a></p>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="fh5co-feature fh5co-feature-sm animate-box" data-animate-effect="fadeInLeft">
								<div class="fh5co-icon">
									<i class="icon-qq"></i>
								</div>
								<div class="fh5co-text">
									<p><a href="http://wpa.qq.com/msgrd?v=3&uin=1126254578&site=qq&menu=yes">1126254578</a></p>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="fh5co-feature fh5co-feature-sm animate-box" data-animate-effect="fadeInLeft">
								<div class="fh5co-icon">
									<i class="icon-phone"></i>
								</div>
								<div class="fh5co-text">
									<p><a href="tel:15881315861">15881315861</a></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="fh5co-narrow-content animate-box" data-animate-effect="fadeInLeft">
				
				<div class="row">
					<div class="col-md-4">
						<h1>Get In Touch</h1>
					</div>
				</div>
				<form action="<?php echo url('main/send_mail'); ?>" method="post">
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<input type="text" class="form-control" placeholder="Name">
									</div>
									<div class="form-group">
										<input type="text" class="form-control" name="email" placeholder="Email">
									</div>
									<div class="form-group">
										<input type="text" class="form-control" placeholder="Phone">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<textarea name="content" id="message" cols="30" rows="7" class="form-control" placeholder="Message"></textarea>
									</div>
									<div class="form-group">
										<input type="submit" class="btn btn-primary btn-md" value="Send Message">
									</div>
								</div>
								
							</div>
						</div>
						
					</div>
				</form>
			</div>

		</div>
	</div>

		<!-- jQuery -->
	<script src="__static__/js/jquery.min.js"></script>
	<!-- jQuery Easing -->
	<script src="__static__/js/jquery.easing.1.3.js"></script>
	<!-- Bootstrap -->
	<script src="__static__/js/bootstrap.min.js"></script>
	<!-- Carousel -->
	<script src="__static__/js/owl.carousel.min.js"></script>
	<!-- Stellar -->
	<script src="__static__/js/jquery.stellar.min.js"></script>
	<!-- Waypoints -->
	<script src="__static__/js/jquery.waypoints.min.js"></script>
	<!-- Counters -->
	<script src="__static__/js/jquery.countTo.js"></script>
	
	<script src="__static__/js/mymap.js"></script>
	<!-- MAIN JS -->
	<script src="__static__/js/main.js"></script>

	</body>
</html>

