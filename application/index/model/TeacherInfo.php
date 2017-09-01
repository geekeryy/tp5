<?php
namespace app\index\model;

class TeacherInfo extends \think\Model{
	function saveInfo($data){
		foreach ($data as $key => $value) {
			if (!$this->where('phone',$value['phone'])->find()) {
				$res=$this->insert($value);
			}
		}
		
		// return $res;
	}
}