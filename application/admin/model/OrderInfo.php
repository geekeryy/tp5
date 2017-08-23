<?php
namespace app\admin\model;
class OrderInfo extends \think\Model{
	/**
	 * 保存订单中商品信息
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	function saveOrderInfo($data){
		$res=$this->insertAll($data);
		return $res;
	}
	/**
	 * 查询订单
	 * @param  [type] $where [description]
	 * @return [type]        [description]
	 */
	function show($where){
		$res=$this->where($where)->select();
		return $res;
	}

}