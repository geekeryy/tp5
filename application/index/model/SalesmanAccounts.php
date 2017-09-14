<?php
namespace app\index\model;

class SalesmanAccounts extends \think\Model{

	/**
	 * 保存销售员账号
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	function saveSalesmanAccount($data){
		$this->insertAll($data['response']['accounts']);
	}

	/**
	 * 保存销售员账号
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	function updateSalesmanAccount($data){
		$this->insertAll($data['response']['accounts']);
	}

	/**
	 * 获取所有销售员手机号
	 * limit从0开始
	 * @return [type] [description]
	 */
	function getAllSalesman(){
		return $this->field('mobile')->where('id > 0')->select();
	}
}