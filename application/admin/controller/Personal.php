<?php
namespace app\admin\controller;

class Personal{
	function _initialize(){
		if (!session('user_openid')) {
			$this->error('请先登录','index/login');
		}
	}

	/**
	 * 展示所有订单
	 * @return [type] [description]
	 */
	function showOrderInfo(){
		$where['user_openid']=session('user_openid');
		$order=model('Order');
		$res=$order->showAll($where);
		$orderinfo=model('OrderInfo');
		$productinfo=model('ProductInfo');
		$arr=array();
		$order=array();
		foreach ($res as $key1 => $value1) {
			$order[$key1]=$orderinfo->show(array('order_id'=>$value1['order_id']));
			$arr[$value1['order_id']]['state']=$value1['state'];
			$arr[$value1['order_id']]['time']=$value1['time'];
			foreach ($order[$key1] as $key2 => $value2) {
				$product=$productinfo->show(array('product_id'=>$value2['product_id']));
				$arr[$value1['order_id']][$value2['product_id']]['name']=$product['name'];
				$arr[$value1['order_id']][$value2['product_id']]['price']=$product['price'];
				$arr[$value1['order_id']][$value2['product_id']]['product_id']=$product['product_id'];
				$arr[$value1['order_id']][$value2['product_id']]['product_num']=$value2['product_num'];

			}
		}
		return var_dump($arr);
	}

}