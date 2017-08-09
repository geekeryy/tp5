<?php
namespace app\index\controller;
use QQ_Login_Api\myclass\QC;
use WX\WX;
class Oauth extends \think\Controller{


	/**
	 * 微信自动登录，无需用户授权
	 * 只获取openid
	 * @return [type] [description]
	 */
	function wxAutoLogin(){
		$wx=new WX();
		$url=$wx->wxAutoLogin();
		$this->redirect($url);
	}

	/**
	 * 微信登录授权
	 * @return [type] [description]
	 */
	function wxLogin(){
		$wx=new WX();
		$url=$wx->wx_login();
		$this->redirect($url);
	}

	/**
	 * 微信授权回调函数
	 * @return [type] [description]
	 */
	function wx_callback(){
		$code=input('get.code');
		$wx=new WX();
		$data=$wx->getAccessToken($code);
		if (isset($data['scope']) && $data['scope']=='snsapi_base') {
			//静默授权，获取openid
			//
			// return $data['openid'];
		}else{
			//不是静默授权，则更新数据库
			//
		}
		$res=$wx->getUserInfo($data);
		var_dump($res);
        session('headimg',$res['headimgurl']);
        session('nickname',$res['nickname']);
        session('wx_user_info',$res);

        $this->success('欢迎您：'.$res["nickname"],'index/index');
	}
	
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