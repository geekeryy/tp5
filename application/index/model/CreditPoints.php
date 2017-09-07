<?php
 namespace app\index\model;

 class CreditPoints extends \think\Model{
 	function saveCreditPointsInfo($data){
 		if (!$this->where('student_id',$data['student_id'])->find()) {
	 		$res=$this->save($data);
	 		return $res;
 		}
 	}

  	function showCreditPoints($student_id){
	 	$res=$this->where('student_id',$student_id)->find();
	 	return $res;
 	}
 }