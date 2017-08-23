<?php
/**
 * 访问统计行为类
 * 访问记录，计数
 */
namespace app\admin\behavior;

class Statistics {
	function run (&$params){
		$ip=request()->ip();
		//过滤微信服务器的访问计数
		if ($ip=='123.151.43.110') {
			return true;
		}
		//访问计数
		$count = new \app\admin\model\Count();
		$res=$count->view($params['page']);
		//访问记录
		$viewinfo = new \app\admin\model\ViewInfo();
		$res=$viewinfo->view($params['wx_openid']);
		return $res;
	}
}