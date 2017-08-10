<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:91:"H:\Git\phpproject\thinkphp_5.0.10_full\public/../application/index\view\index\register.html";i:1502354720;}*/ ?>
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
  <!-- <script type="text/javascript" src="__static__/js/jquery-1.7.2.min.js"></script> -->
  <script type="text/javascript">

  	
  	function checkreginfo(){
  		var accminlength=6;
  		var accmaxlength=20;
  		var pwdminlength=6;
  		var pwdmaxlength=20;
  		var account=document.getElementById('account').value;
  		var password=document.getElementById('password').value;
  		var repassword=document.getElementById('repassword').value;
  		if (account=="") {
  			document.getElementById('send').innerHTML='账号不能为空';
  			return false;
  		}
  		else if (account.length<accminlength || account.length >accmaxlength) {
  			document.getElementById('send').innerHTML="账号长度在"+accminlength+"~"+accmaxlength+"之间";
  			return false;
  		}
  		else if (password=="") {
  			document.getElementById('send').innerHTML='密码不能为空';
  			return false;
  		}else if(password.length<pwdminlength || password.length>pwdmaxlength){
  			document.getElementById('send').innerHTML="密码长度在"+pwdminlength+"~"+pwdmaxlength+"之间";
  			return false;
  		}
  		else if(repassword!=password){
			document.getElementById('send').innerHTML='密码不一致';
			return false;
  		}
  		document.getElementById('send').innerHTML='注册';
  		$("#send").removeAttr("disabled");
  		return true;
  	}

  	
  	
  </script>
</head>
<body>
<div class="am-g">
	<!-- LOGO -->
	<div class="am-u-sm-12 am-text-center" >
		 <a href="<?php echo url('index/index'); ?>"><i class="am-icon-twitch myapp-login-logo"></i></a>
	</div>

	<!-- 登陆框 -->
	<div class="am-u-sm-11 am-u-sm-centered">
	<form class="am-form"  onsubmit="return checkreginfo();"  action="<?php echo url('user/register'); ?>" method="post">
	  <fieldset class="myapp-login-form am-form-set">
		<div class="am-form-group am-form-icon">
			<i class="am-icon-user"></i>
			<input type="text" class="myapp-login-input-text am-form-field" id="account" onblur="checkreginfo()" name="account" placeholder="请输入您的账号">
		</div>
	    <div class="am-form-group am-form-icon">
			<i class="am-icon-lock"></i>
			<input type="text" class="myapp-login-input-text am-form-field" id="password" onblur="checkreginfo()" name="password" placeholder="请输入密码">

		</div>

		<div class="am-form-group am-form-icon">
			<i class="am-icon-lock"></i>
			<input type="text" class="myapp-login-input-text am-form-field" id="repassword"  onblur="checkreginfo()" name="repassword" placeholder="请确认密码">
		</div>
	  </fieldset>
	  <button type="submit" id="send" disabled class="myapp-login-form-submit am-btn am-btn-primary am-btn-block ">注 册</button>
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