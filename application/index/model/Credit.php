<?php
 namespace app\index\model;

 class Credit extends \think\Model{
 	function saveCreditInfo($data){
 		if (!$this->where('student_id',$data['0']['student_id'])->find()) {
 			$res=$this->insertAll($data);
 			return $res;
 		}
 	}

 	function showCredit($student_id){
 		$res=$this->where('student_id',$student_id)->select();
 		return $res;
 	}
 }