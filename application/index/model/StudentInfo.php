<?php
namespace app\index\model;

class StudentInfo extends \think\Model{

	/**
	 * Reptile爬取新生信息使用，一次性函数，已经使用完毕
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	function saveInfo($data){
		$res=$this->insertAll($data);
		return $res;
	}

	function show($where){
		$res=$this->where($where)->select();
		return $res;
	}

	/**
	 * 依据学号查找学生
	 * @param  [type] $student_id [description]
	 * @return [type]             [description]
	 */
	function showStudent($student_id){
		$res=$this->where('student_id',$student_id)->find();
		return $res;
	}

	/**
	 * 查询出所有班级
	 * @return [type] [description]
	 */
	function showClasses(){
		$res=$this->distinct(true)->field('classes')->select();
		$res=json_decode(json_encode($res),true);
		foreach ($res as $key => $value) {
			$res2=$this->field('number,classes,campus,college,major')->where('classes',$value['classes'])->find();

			$res3[$key]=json_decode(json_encode($res2),true);
		}
		return $res3;
	}

	/**
	 * 学号分析
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	function studentIdAnalysis($data){
		$sql='select college,major,classes from tp5_student_info where student_id like __1010702% limit 1';
		$res=$this->field('college,major,classes')->where('student_id','like','__'.$data.'__')->find();
		return $res;
	}




	/**
	 * 更新学生地址信息，一次性函数（已经使用完毕）
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	function updateStudentInfo($data){
		$info['address']=$data['address'];
		$where['number']=$data['number'];
		$res=$this->where($where)->update($info);
		return $res;
	}
	/**
	 * 获取学号，一次性函数（已经使用完毕）
	 * @return [type] [description]
	 */
	function getStudentId(){
		$res=$this->field('number')->where('address is null')->limit(100)->select();
		return $res;
	}
	
}