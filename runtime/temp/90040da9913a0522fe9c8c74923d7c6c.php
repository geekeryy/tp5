<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:87:"H:\Git\phpproject\thinkphp_5.0.10_full\public/../application/index\view\index\test.html";i:1501651280;}*/ ?>
<!DOCTYPE html>
<html> 
<head> 
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
    <title>前端定位模块</title> 
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <style>
        * {
            margin: 0;
            padding: 0;
            border: 0;
        }
        body {
            position: absolute;
            width: 100%;
            height: 100%;
            text-align: center;
        }
        #pos-area {
            background-color: #009DDC;
            margin-bottom: 10px;
            width: 100%;
            overflow: scroll;
            text-align: left;
            color: white;
        }
        #demo {
            padding: 8px;
            font-size: small;
        }
        #btn-area {
            height: 100px;
        }
        button {
            margin-bottom: 10px;
            padding: 12px 8px;
            width: 42%;
            border-radius: 8px;
            background-color: #009DDC;
            color: white;
        }
    </style>
    <script type="text/javascript" src="https://3gimg.qq.com/lightmap/components/geolocation/geolocation.min.js"></script>
</head>
<body>
    <div id="pos-area">
        <p id="demo">点击下面的按钮，获得对应信息：<br /></p>
    </div>
 
    <div id="btn-area">
        <button onClick="geolocation.getLocation(showPosition, showErr, options)">获取精确定位信息</button>
        <button onClick="geolocation.getIpLocation(showPosition, showErr)">获取粗糙定位信息</button>
        <button onClick="showWatchPosition()">开始监听位置</button>
        <button onClick="showClearWatch()">停止监听位置</button>
    </div>
    <script type="text/JavaScript">
        var geolocation = new qq.maps.Geolocation("DHOBZ-N7AKS-O2XOY-6W5TK-AZT37-P4BL6", "myapp");
 
        document.getElementById("pos-area").style.height = (document.body.clientHeight - 110) + 'px';
 
        var positionNum = 0;
        var options = {timeout: 8000};
        function showPosition(position) {
            positionNum ++;
            document.getElementById("demo").innerHTML += "序号：" + positionNum;
            document.getElementById("demo").appendChild(document.createElement('pre')).innerHTML = JSON.stringify(position, null, 4);
            document.getElementById("pos-area").scrollTop = document.getElementById("pos-area").scrollHeight;
        };
 
        function showErr() {
            positionNum ++;
            document.getElementById("demo").innerHTML += "序号：" + positionNum;
            document.getElementById("demo").appendChild(document.createElement('p')).innerHTML = "定位失败！";
            document.getElementById("pos-area").scrollTop = document.getElementById("pos-area").scrollHeight;
        };
 
        function showWatchPosition() {
            document.getElementById("demo").innerHTML += "开始监听位置！<br /><br />";
            geolocation.watchPosition(showPosition);
            document.getElementById("pos-area").scrollTop = document.getElementById("pos-area").scrollHeight;
        };
 
        function showClearWatch() {
            geolocation.clearWatch();
            document.getElementById("demo").innerHTML += "停止监听位置！<br /><br />";
            document.getElementById("pos-area").scrollTop = document.getElementById("pos-area").scrollHeight;
        };
    </script>
</body>
</html>