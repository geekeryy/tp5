<?php

namespace app\index\model;
class PayInfo extends \think\Model{
	function savePayInfo($data){
		//保存用户支付信息
		$res=$this->save($data);
		return $res;
	}
}