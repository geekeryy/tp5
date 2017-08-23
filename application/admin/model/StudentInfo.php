<?php
namespace app\admin\model;
use \think\Db;
class StudentInfo extends \think\Model{
	function show($pn,$num){
		$start=($pn-1)*$num;
		$res=$this->limit($start,$num)->select();
		return $res;
	}
	function search($where,$pn,$num){
		$start=($pn-1)*$num;
		$res=$this->where('dorm','like','%'.$where.'%')->whereOr('student_id','like','%'.$where.'%')->whereOr('campus','like','%'.$where.'%')->whereOr('number','like','%'.$where.'%')->whereOr('sex','like','%'.$where.'%')->whereOr('classes','like','%'.$where.'%')->whereOr('college','like','%'.$where.'%')->whereOr('name','like','%'.$where.'%')->whereOr('major','like','%'.$where.'%')->limit($start,$num)->select();
		return $res;
	}

	function total($where=''){

		if (!$where) {
			$res=$this->count();
		}else{
			$res=$this->where('dorm','like','%'.$where.'%')->whereOr('student_id','like','%'.$where.'%')->whereOr('campus','like','%'.$where.'%')->whereOr('number','like','%'.$where.'%')->whereOr('sex','like','%'.$where.'%')->whereOr('classes','like','%'.$where.'%')->whereOr('college','like','%'.$where.'%')->whereOr('name','like','%'.$where.'%')->whereOr('major','like','%'.$where.'%')->count();
		}
		return $res;
	}
}