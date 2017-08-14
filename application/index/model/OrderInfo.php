<?php
namespace app\index\model;
class OrderInfo extends \think\Model{
	function saveOrderInfo($data){
		$res=$this->insertAll($data);
		return $res;
	}

}