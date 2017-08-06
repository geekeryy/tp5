<?php
namespace app\index\controller;
use QQ_Login_Api\myclass\QC;
class Oauth extends \think\Controller{
	
	/*
	唤起QQ授权
	*/
	function qq_login(){
		$qc=new QC();
		$login_url=$qc->qq_login();
		$this->redirect($login_url);
	}
	/*
	QQ登录回调函数
	*/
	function callback(){
		$qc=new QC();
		$code=$qc->qq_callback();
		$openid=$qc->get_openid();
		$qc=new QC($code,$openid);
		//获取用户信息
		$arr=$qc->get_user_info();
		session('openid',$openid);
		session('info',$arr);
		//将用户信息存入数据库

		//登录成功，重定向到指定页面
		$this->redirect(config('callback_url'),302);
	}

}