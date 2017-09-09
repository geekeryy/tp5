<?php
namespace app\index\model;

class PersonalInfo extends \think\Model{

	/**
	 * 用户登录教务管理系统时，保存用户信息
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	function savePersonalInfo($data){
		if (!$this->where('xh',$data['xh'])->find()) {
			$res=$this->save($data);
			return $res;
		}
		
	}

	/**
	 * 保存登录计财处的学生信息
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	function saveJccStudent($data){
		if ($this->where('xh',$data['xh'])->find()) {
			$this->where('xh',$data['xh'])->update($data);
		}else{
			$this->save($data);
		}
	}

}