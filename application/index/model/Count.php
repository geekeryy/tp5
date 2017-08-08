<?php
namespace app\index\model;

class Count extends \think\Model{
	function viewCount(){
		//一天的第一次访问，插入数据库
		$res=$this->field('id')->where('time',date('Y-m-d',time()))->find();
		if (!$res) {
			$data['view']=1;
			$data['time']=date('Y-m-d',time());
			$res=$this->save($data);
		}else{
			//第二次访问更新数据库
			$res=$this->where('time',date('Y-m-d',time()))->setInc('view',1);
		}
		return $res;
	}
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