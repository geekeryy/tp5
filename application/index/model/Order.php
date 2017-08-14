<?php
namespace app\index\model;

class Order extends \think\Model{
	/**
	 * 查询订单
	 * @param  [type] $where [description]
	 * @return [type]        [description]
	 */
	function show($where){
		$res=$this->where($where)->find();
		return $res;
	}
	/**
	 * 保存订单
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	function saveOrder($data){
		$res=$this->save($data);
		return $res;
	}
	/**
	 * 更新订单状态
	 * @param [type] $where [description]
	 */
	function changeState($where){
		$data['time']=date('Y-m-d h:i:s',time());
		$data['state']=1;
		$res=$this->where($where)->update($data);
		return $res;
	}
}