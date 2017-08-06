<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/*使对应导航栏高亮*/
function aside($str,$fun){
	if ($str==$fun) {
		echo 'class="fh5co-active"';
	}
	
}

/*显示QQ登录对应用户头像*/
function logo($logo){
	if (isset($logo) && !empty($logo)) {
		# code...
		echo 'src="'.$logo.'"';
	}else{
		echo 'src="__static__/images/logo-colored.png"';
	}
}