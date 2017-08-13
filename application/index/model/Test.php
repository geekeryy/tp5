<?php
namespace app\index\model;

class Test extends \think\Model{
	function test($data){

		// $res=$this->save(array('data'=>$data['openid']));
		$res=$this->save($data);
		return $res;
	}
	function show(){
		$res=$this->where('id','>',0)->select();
		return $res;
	}
}