<?php
namespace app\index\model;

class ProductInfo extends \think\Model{
	function countTotalFee($data){
		(int)$fee=0;
		foreach ($data as $key => $value) {
			$res=$this->where('product_id',$value['product_id'])->find();
			(int)$fee=(int)$fee+(int)$res['price']*(int)$value['product_num'];
		}
		return (int)$fee;
	}
}