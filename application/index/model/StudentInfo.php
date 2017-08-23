<?php
namespace app\index\model;

class StudentInfo extends \think\Model{
	function saveInfo($data){
		$res=$this->insertAll($data);
		return $res;
	}
	function show(){
		$res=$this->where('id','>',0)->select();
		return $res;
	}
	
}