<?php
namespace app\index\model;

class SuseInfo extends \think\Model{

	/**
	 * 保存用户教务管理系统和计财处账号
	 * 用户更换密码，下次登录时自动更新
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	function saveSuse($data){
		
		if (!$res=$this->where($data)->find()) {
			//如果不存在对应账号，则注册
			if ($res1=$this->where('student_id',$data['student_id'])->find()) {
				//老用户修改了密码后登录,只更新密码和时间
				$res1=json_decode(json_encode($res1),true);
				$data['last_time']=date('Y-m-d H:i:s',time());
				session('user_openid',$res1['openid']);
				$res=$this->where('openid',$res1['openid'])->update($data);
			}else{
				//新用户注册
				$data['openid']=md5(time().rand(1000,9999));
				session('user_openid',$data['openid']);
				$data['last_time']=date('Y-m-d H:i:s',time());
				$res=$this->save($data);
			}
			return $res;

		}else{
			//存在账号即为登录
			$res=json_decode(json_encode($res),true);
			session('user_openid',$res['openid']);
		}
		
	}

	/**
	 * 查找用户，绑定qq时使用
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	function findUser($data){
		$res=$this->where($data)->find();
		return $res;
	}

	/**
	 * 綁定QQ
	 * 再次绑定即为更新绑定
	 * 此qq绑定的suse和jcc账号将同时更换绑定
	 * @return [type] [description]
	 */
	function bindQQ($data){
		$info['qq_openid']=$data['qq_openid'];
		$where['openid']=$data['openid'];
		$info['last_time']=date('Y-m-d H:i:s',time());
		$res=$this->where($where)->update($info);
		return $res;
	}

	/**
	 * 获取学号
	 * @param  [type] $user_openid [description]
	 * @return [type]              [description]
	 */
	function getStudentId($user_openid){
		return $this->field('student_id')->where('openid',$user_openid)->find();
	}
}