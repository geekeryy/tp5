<?php
namespace app\index\model;

class TeacherInfoCopy extends \think\Model{
	function saveInfo($data){
		foreach ($data as $key => $value) {
			if (!$this->where('classes',$value['classes'])->find()) {
				$res=$this->insert($value);
			}
		}
		
		// return $res;
	}
}