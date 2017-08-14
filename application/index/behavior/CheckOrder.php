<?php
namespace app\index\behavior;

class CheckOrder{
	function run(&$params){
		$where['order_id']=$params['attach'];
		$order = new \app\index\model\Order();
		if ($res=$order->show($where)) {
			//如果支付回调返回的总金额不等于订单的总金额，返回失败
			if ($res['total_fee']!=$params['total_fee']) {
				return false;
			}
		}
		//订单状态改为成功支付
		$res=$order->changeState($where);
		return $res;
	}
}