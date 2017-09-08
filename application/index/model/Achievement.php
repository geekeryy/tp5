<?php

namespace app\index\model;

class Achievement extends \think\Model{

	/**
	 * 保存成绩1
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	function saveAchievement($data){
		if (!$this->where('student_id',$data[0]['student_id'])->find()) {
			$this->insertAll($data);
		}
	}

	/**
	 * 更新成绩2
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	function updateAchievement($data){
		if (!$this->where('student_id',$data[0]['student_id'])->find()) {
			foreach ($data as $key => $value) {
				$where['student_id']=$value['student_id'];
				$where['course_id']=$value['course_id'];
				$this->where($where)->update($value);
			}
		}
	}

	/**
	 * 展示成绩
	 * @param  [type] $user [description]
	 * @return [type]       [description]
	 */
	function showAchievement($user){
		$res=$this->where('student_id',$user)->select();
		return $res;
	}
}