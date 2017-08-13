<?php
namespace app\index\model;

class Count extends \think\Model{
	/**
	 * 用户访问，更新数据库操作
	 * @param  [type] $params [description]
	 * @return [type]         [description]
	 */
	function view($params){
		//一天的第一次访问，插入数据库
		$where['time']=date('Y-m-d',time());
		$where['page']=$params;
		if (!$this->where($where)->find()) {
			$data['view']=1;
			$data['time']=date('Y-m-d',time());
			$data['page']=$params;
			$res=$this->save($data);
		}else{
			//第二次访问更新数据库
			$res=$this->where($where)->setInc('view',1);
		}
		return $res;
	}

	/**
	 * 获取访问数据
	 * @return [type] [description]
	 */
	function getCount(){
		$res1=$this->where('time',date('Y-m-d',time()))->find();
		$data['today']=$res1['view'];
		$res2=$this->where('time','>',date('Y-m-d',time()-604800))->sum('view');
		$data['week']=$res2;
		$res3=$this->sum('view');
		$data['all']=$res3;
		return $data;
	}
}