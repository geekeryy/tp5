<?php
namespace app\index\model;

class StudentInfo extends \think\Model{
	function saveInfo($data){
		$res=$this->insertAll($data);
		return $res;
	}
	function saveStudent($info){
		if (!$this->where('name',$info['name'])->find()) {
			$data['name']=$info['name'];
			$data['student_id']=$info['student_id'];
			$data['college']=$info['college'];
			$data['major']=$info['major'];
			$data['classes']=$info['classes'];

			$this->insert($data);		
		}
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