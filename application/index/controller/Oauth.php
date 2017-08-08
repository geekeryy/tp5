<?php
namespace app\index\controller;
use QQ_Login_Api\myclass\QC;
class Oauth extends \think\Controller{

	/**
	 * 微信登录授权
	 */
	function wx_login(){
		//1.请求code
		$url='https://open.weixin.qq.com/connect/oauth2/authorize?';
		$param='appid='.config("wx_appid").'&redirect_uri='.config("wx_callback").'&response_type=code&scope='.config("wx_scope").'&state=STATE#wechat_redirect';
        $this->redirect($url.$param);
	}
	/**
	 * 微信授权回调函数
	 */
	function wx_callback(){
		//2.获取code，请求access_token和openid
		$code=input('get.code');
		$url='https://api.weixin.qq.com/sns/oauth2/access_token?';
		$param='appid='.config("wx_appid").'&secret='.config("wx_appscript").'&code='.$code.'&grant_type=authorization_code ';

		$ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL,$url.$param);
        $response =  curl_exec($ch);

        //3.获得access_token和openid，请求用户信息
        $res=json_decode($response,true);
        $access_token=$res['access_token'];
        $openid=$res['openid'];
        $url='https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN ';
        curl_setopt($ch, CURLOPT_URL,$url);
        $response =  curl_exec($ch);
        curl_close($ch);
        //4.获得用户信息
        $res=json_decode($response,true);
        session('headimg',$res['headimgurl']);
        $this->success('欢迎您：'.$res["nickname"],'index/index');
        // return $response;
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