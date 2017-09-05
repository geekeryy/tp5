<?php
namespace app\index\model;

class CourseInfo extends \think\Model{
	function saveCourseInfo($info2,$info1){
		if (!$this->where('student_id',$info1['student_id'])->find()) {
		$data['student_id']=$info1['student_id'];
		$data['year']=$info1['year'];
		$data['semester']=$info1['semester'];

			foreach ($info2 as $key => $value) {
				$data['course']=$value['0'];
				$data['type']=$value['1'];
				$data['time']=$value['2'];
				$data['teacher']=$value['3'];
				$data['classroom']=$value['4'];
				$this->insert($data);

				if (count($value)>5) {
					$data['course']=$value['6'];
					$data['type']=$value['7'];
					$data['time']=$value['8'];
					$data['teacher']=$value['9'];
					$data['classroom']=$value['10'];
					$this->insert($data);
				}
			}

		}
	}
}