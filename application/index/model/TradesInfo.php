<?php
namespace app\index\model;

class TradesInfo extends \think\Model{

	/**
	 * 更新保存交易信息
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	function saveTradesInfo($data){
		//数据过滤allowField(true)
		if (!$this->where('order_no',$data['order_no'])->find()) {
			$this->insert($data);
		}else{
			$this->where('order_no',$data['order_no'])->update($data);
		}
	}
}