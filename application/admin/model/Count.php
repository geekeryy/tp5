<?php
namespace app\admin\model;

class Count extends \think\Model{
	function show(){
		$res=$this->where('id','>',0)->select();
		return $res;
	}
}