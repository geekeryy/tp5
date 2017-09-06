<?php

namespace app\index\model;

class Achievement extends \think\Model{
	function saveAchievement($data){
		if (!$this->where('student_id',$data[0]['student_id'])->find()) {
			$this->insertAll($data);
		}
	}

	function showAchievement($user){
		$res=$this->where('student_id',$user)->select();
		return $res;
	}
}