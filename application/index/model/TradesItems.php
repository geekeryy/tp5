<?php
namespace app\index\model;

class TradesItems extends \think\Model{

	/**
	 * 保存交易信息
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	function saveInfo($data){
		if (!$this->where('order_no',$data[0]['order_no'])->find()) {
			$this->insertAll($data);
		}
	}
}