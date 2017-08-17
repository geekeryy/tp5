<?php
namespace app\index\model;

class ProductInfo extends \think\Model{
	/**
	 * 计算订单总金额
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	function countTotalFee($data){
		(int)$fee=0;
		foreach ($data as $key => $value) {
			$res=$this->where('product_id',$value['product_id'])->find();
			(int)$fee=(int)$fee+(int)$res['price']*(int)$value['product_num'];
		}
		return (int)$fee;
	}

	/**
	 * 查询订单
	 * @param  [type] $where [description]
	 * @return [type]        [description]
	 */
	function show($where){
		$res=$this->where($where)->find();
		return $res;
	}
}