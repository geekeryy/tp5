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
	 * 更新销售员账号
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	function updateSalesmanAccount($data){
		foreach ($data as $key => $value) {
			if (!$this->where('mobile',$value['mobile'])) {
				$this->insert($value);
			}else{
				$this->where('mobile',$value['mobile'])->update($value);
			}
		}
	}

	/**
	 * 获取所有销售员手机号
	 * limit从0开始计数
	 * @return [type] [description]
	 */
	function getAllSalesman(){
		return $this->field('mobile')->where('id > 0')->limit(10)->select();
	}

	/**
	 * 获得个人累计销量
	 * @param  [type] $where [mobile]
	 * @return [type]        [description]
	 */
	function getPerCumulativeSales($where){
		$res=$this->field('money')->where($where)->find();
		// $res=json_decode(json_encode($res),true);
		return $res;
	}

	/**
	 * 获得团队累计销量
	 * @param  [type] $where [tram_id]
	 * @return [type]        [description]
	 */
	function getTeamCumulativeSales($where){
		$res=$this->field('money')->where($where)->select();
		// $res=json_decode(json_encode($res),true);
		return $res;
	}

	/**
	 * [getTeamer description]
	 * @param  [type] $where [description]
	 * @return [type]        [description]
	 */
	function getTeamer($where){
		return $this->where($where)->select();
	}

	/**
	 * 获取销售员手机号
	 * @param  [type] $where [description]
	 * @return [type]        [description]
	 */
	function getSalesman($where){
		$res=$this->field('mobile,nickname')->where($where)->select();
		$res=json_decode(json_encode($res),true);
		return $res;
	}
}