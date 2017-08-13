<?php
/**
 * 访问统计行为类
 */
namespace app\index\behavior;

class Statistics {
	function run (&$params){
		$count = new \app\index\model\Count();
		$res=$count->view($params);
		return $res;
	}
}