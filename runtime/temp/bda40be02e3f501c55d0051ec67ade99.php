<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:90:"H:\Git\phpproject\thinkphp_5.0.10_full\public/../application/index\view\index\mailreg.html";i:1502170223;}*/ ?>
<!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>Amaze UI Examples</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp"/>
  <link rel="stylesheet" href="__static__/css/amazeui.min.css">
  <link rel="stylesheet" href="__static__/css/app.css">
</head>
<body>
<div class="am-g">
	<!-- LOGO -->
	<div class="am-u-sm-12 am-text-center" >
		 <a href="<?php echo url('index/index'); ?>"><i class="am-icon-twitch myapp-login-logo"></i></a>
	</div>
	<!-- 登陆框 -->
	<div class="am-u-sm-11 am-u-sm-centered">
	<form class="am-form" action="<?php echo url('user/mailReg'); ?>" method="post">
	  <fieldset class="myapp-login-form am-form-set">
		<div class="am-form-group am-form-icon">
			<i class="am-icon-user"></i>
			<input type="text" class="myapp-login-input-text am-form-field" name="email" placeholder="请输入您的邮箱">
		</div>
	    <div class="am-form-group am-form-icon">
			<i class="am-icon-lock"></i>
			<input type="text" class="myapp-login-input-text am-form-field" name="password" placeholder="请输入密码">
		</div>
		<div class="am-form-group am-form-icon">
			<i class="am-icon-lock"></i>
			<input type="text" class="myapp-login-input-text am-form-field" name="repassword" placeholder="请确认密码">
		</div>
	  </fieldset>
	  <button type="submit" class="myapp-login-form-submit am-btn am-btn-primary am-btn-block ">邮 箱 注 册</button>
	</form>
	</div>
	<div class="am-text-center am-u-sm-11 am-u-sm-centered myapp-login-form-shortcut">
		<hr class="myapp-login-form-hr" />
		<span class="myapp-login-form-hr-font">第三方登陆</span>
	</div>

	<div class="am-u-sm-12 am-text-center myapp-login-form-listico" >
		 <div class="am-u-sm-4 am-text-center" >
		 <a href="<?php echo url('oauth/qq_login'); ?>">
		 <i class="am-icon-btn am-primary am-icon-qq"></i>
		 </a>
		 </div>
		 <div class="am-u-sm-4 am-text-center" >
		 <a href="<?php echo url('oauth/qq_login'); ?>">
		 <i class="am-icon-btn am-primary am-icon-weixin"></i>
		 </a>
		 </div>
		 <div class="am-u-sm-4 am-text-center" >
		 <a href="<?php echo url('oauth/qq_login'); ?>">
		 <i class="am-icon-btn am-primary am-icon-weibo"></i>
		 </a>
		 </div>
	</div>

	<div class="am-text-center am-u-sm-11 am-u-sm-centered myapp-login-form-shortcut">
	</div>
	<div class="am-u-sm-12 am-text-left">
	<p ><a href="<?php echo url('index/login'); ?>">已有账号？立即登录</a></p>
	</div>


</div>


<!--[if (gte IE 9)|!(IE)]><!-->
<script src="__static__/js/jquery.min.js"></script>
<!--<![endif]-->
<!--[if lte IE 8 ]>
<script src="http://libs.baidu.com/jquery/1.11.3/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="assets/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->
<script src="__static__/js/amazeui.min.js"></script>
<script src="__static__/js/app.js"></script>
</body>
</html>