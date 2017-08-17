<?php

namespace app\index\model;
class PayInfo extends \think\Model{
	/**
	 * 保存用户支付信息
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	function savePayInfo($data){
		//保存用户支付信息
		$res=$this->save($data);
		return $res;
	}
}