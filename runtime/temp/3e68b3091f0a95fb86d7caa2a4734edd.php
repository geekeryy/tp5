<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:88:"H:\Git\phpproject\thinkphp_5.0.10_full\public/../application/index\view\index\test2.html";i:1502183799;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
<script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp&key=d84d6d83e0e51e481e50454ccbe8986b"></script>
<script type="text/javascript" src="https://3gimg.qq.com/lightmap/components/geolocation/geolocation.min.js"></script>
<script src="__static__/js/tencentmap.js"></script>
<style type="text/css">
	#map{
		width:100%;
		height:500px;
	}
</style>
</head>
<body>
<div id='map'></div>
<button onclick='get_map()'>画地图</button>
<button onclick='get_position()'>获取地理位置</button>
<!-- <button onclick='init()'>画地图</button> -->
<br>

</body>
</html>