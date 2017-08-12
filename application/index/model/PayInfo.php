<?php

namespace app\index\model;
class PayInfo extends \think\Model{
	function savePayinfo($data){
		//保存用户支付信息
		$res=$this->save($data);
		return $res;
	}
}