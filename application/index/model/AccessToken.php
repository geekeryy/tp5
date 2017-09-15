<?php
namespace app\index\model;

class AccessToken extends \think\Model{
	function saveAccessToken($data){
		$info['access_token']=$data;
		$info['create_time']=date('Y-m-d H:i:s',time());
		$res=$this->save($info);
		return $res;
	}
	function getAccessToken(){
		$date=date('Y-m-d H:i:s',time()-600000);
		$res=$this->field('access_token,create_time')->where('create_time','>',$date)->find();
		return $res;
	}
}