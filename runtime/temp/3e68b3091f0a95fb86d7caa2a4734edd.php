<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:88:"H:\Git\phpproject\thinkphp_5.0.10_full\public/../application/index\view\index\test2.html";i:1501935960;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
hello 
<a href="www.baidu.com">百度</a>
<br>

<br>
<?php echo \think\Session::get('openid'); ?>
<?php echo var_dump(\think\Session::get('info')); ?>
</body>
</html>