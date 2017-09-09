<?php
namespace app\index\model;

class JccFee extends \think\Model{
	function saveFeeInfo($data){
		if (!$this->where('student_id',$data[0]['student_id'])->find()) {
			$this->insertAll($data);
		}
	}
}