<?php
namespace app\index\controller;
use Yunpian\YunpianApi;
class Main extends \think\Controller{
	function __construct(){
		//
	}

	/*
	发送短信验证码
	*/
	function send_message(){
		//
		if (!empty(session('yunpian'))) {
			# code...
			session('yunpian','');
		}
		//获取ajax传递的phones值
		$phones=input('post.phones');
		//发送验证码短信
		$send=new YunpianApi();
		$arr=$send->send_tpl($phones);
		//如果返回状态码不为0，则返回错误信息
		if($arr['code']){
			return $arr['msg'];
		}
		//存储api创建的code
		session('yunpian',$arr['yunpian']);
	} 


	/*
	用户手机号验证
	*/
	function bindPhone(){

		//判断验证码是否正确
		if(input('code')==session('yunpian.code') && !empty(input('code'))){
			//验证码超时判断
			if (time()-session('yunpian.time')>60) {
				$this->error('验证码超时，请重新获取');
			}
			//验证成功，则清除session
			session('yunpian.code','');
			$this->success('验证成功','index/index');
		}else{
			$this->error('验证失败');
		}
	}

	/*
	查看session的工具函数
	*/
	function session(){
		var_dump(session(''));
	}
}