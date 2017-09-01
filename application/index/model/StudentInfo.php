<?php
namespace app\index\model;

class StudentInfo extends \think\Model{
	function saveInfo($data){
		$res=$this->insertAll($data);
		return $res;
	}
	function show($where){
		$res=$this->where($where)->select();
		return $res;
	}

	function showClasses(){
		// $res=$this->distinct(true)->field('classes')->count('distinct(classes)');
		$res=$this->distinct(true)->field('classes')->select();
		$res=json_decode(json_encode($res),true);
		foreach ($res as $key => $value) {
			$res2=$this->field('number,classes,campus,college,major')->where('classes',$value['classes'])->find();

			$res3[$key]=json_decode(json_encode($res2),true);
		}
		// var_dump($res3);
		// exit();
		return $res3;
	}
	
}