		//获取地理位置并画出地图
		function tencent_map(){
 			geolocation.getLocation(showPosition, showErr, options);
 		}
 		//初始化
        var geolocation = new qq.maps.Geolocation("DHOBZ-N7AKS-O2XOY-6W5TK-AZT37-P4BL6", "myapp");
        var options = {timeout: 8000};

        function showPosition(position) {
        	// document.getElementById("msg").innerHTML="您在"+position.province+position.city+position.addr;
            init(position.lat,position.lng);
        };
        //画出默认位置的地图
        function init(lat,lng) {
	        //定义map变量 调用 qq.maps.Map() 构造函数   获取地图显示容器
	        //实例化一个位置对象
	        if(lat!=null){
	        }else{
	        	lat=29.3318;
	        }
	        if(lng!=null){
	        }else{
	        	lng=104.765701;
	        }
	        var center=new qq.maps.LatLng(lat,lng);
	        //画地图
	        var map = new qq.maps.Map(document.getElementById("map"), {
	            center: center,      // 地图的中心地理坐标。
	            zoom:16                                                // 地图的中心地理坐标。
	        });
	        //设置标记
		    var marker = new qq.maps.Marker({
		        position: center,
		        animation:qq.maps.MarkerAnimation.DROP,
		        map: map
		    });
		    //监听标记点击事件
		    qq.maps.event.addListener(marker,"click",function(){
		        alert("四川省自贡市自流井区四川理工学院汇南校区");
		    });

    	}
    	//定位失败处理
         function showErr() {
            document.getElementById("map").appendChild(document.createElement('p')).innerHTML = "定位失败！";
            // document.getElementById("pos-area").scrollTop = document.getElementById("pos-area").scrollHeight;
        };
