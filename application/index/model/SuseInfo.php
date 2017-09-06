<?php
namespace app\index\model;

class SuseInfo extends \think\Model{
	function saveSuse($data){
		if (!$this->where($data)->find()) {
			$res=$this->save($data);
		}
		
	}
}