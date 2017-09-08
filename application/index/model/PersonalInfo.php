<?php
namespace app\index\model;

class PersonalInfo extends \think\Model{
	function savePersonalInfo($data){
		if (!$this->where('xh',$data['xh'])->find()) {
			$res=$this->save($data);
			return $res;
		}
		
	}
}