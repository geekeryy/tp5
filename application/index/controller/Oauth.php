<?php
namespace app\index\controller;
use QQ_Login_Api\myclass\QC;
class Oauth extends \think\Controller{
	
	/*唤起QQ授权*/
	function qq_login(){
		$qc=new QC();
		$login_url=$qc->qq_login();
		$this->redirect($login_url);
	}
	/*QQ登录回调函数*/
	function callback(){
		$qc=new QC();
		$code=$qc->qq_callback();
		$openid=$qc->get_openid();
		$qc=new QC($code,$openid);
		//获取用户信息
		$arr=$qc->get_user_info();
		session('info',$arr);
		//将用户信息存入数据库
		$data=array('info'=>$arr,'openid'=>$openid);
		$user=model('UserInfo');
		$res=$user->qq_saveUser($data);
		switch ($res) {
				case 0:
					$this->error('数据写入失败！');
					break;
				case 1:
					$this->success('成功，正在返回首页！','index/index');
					break;
				default:
					$this->error('未知错误!');
					break;
			}
	}

}