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

	function bindWX(){
		$wx=new WX();
		$url=$wx->wx_login();
		session('bindWX',1);
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
		$user=model('UserInfo');
		//微信静默登录
		if (isset($data['scope']) && $data['scope']=='snsapi_base') {
			//通过openid获取用户信息
			
			if ($res=$user->findUser(array('wx_openid'=>$data['openid']))) {
				session('user_openid',$res['openid']);
				session('img_url',$res['img_url']);
			}
			//证明已经被微信自动登录过一次，不会再次登录
			session('wxAutoLogin',1);
			session('wx_openid',$data['openid']);
			$this->redirect('index/index');
		}else{

			//如果是綁定微信
			if (session('bindWX')) {
				session('bindWX',null);
				//檢查微信是否被綁定
				$wxarr=array('wx_openid'=>$data['openid']);
				if ($user->findUser($wxarr)) {
					$this->error('此微信已被綁定','index/index');
				}
				if (!session('user_openid')) {
					$this->error('请先登录！');
				}
				if ($user->bindWX($wxarr)) {
					$this->success('微信綁定成功！','index/index');
				}else{
					$this->error('微信綁定失敗!');
				}
			}

			//拉取授权登录或注册
			$res=$wx->getUserInfo($data);
			if ($user->wxSaveUser($res)) {
				session('wxAutoLogin',null);
				$this->success('欢迎您：'.$res["nickname"],'index/index');
			}else{
				//登录刷新数据失败，或者注册插入数据失败
				$this->error('数据写入失败！');
			}
		}

	}
	
	/*唤起QQ授权*/
	function qqLogin(){
		$qc=new QC();
		$login_url=$qc->qq_login();
		$this->redirect($login_url);
	}

	function bindQQ(){
		$qc=new QC();
		$login_url=$qc->qq_login();
		session('bindQQ',1);
		$this->redirect($login_url);	
	}
	/*QQ登录回调函数*/
	function callback(){
		$qc=new QC();
		$code=$qc->qq_callback();
		$openid=$qc->get_openid();
		$qc=new QC($code,$openid);
		$user=model('UserInfo');
		//綁定QQ
		if (session('bindQQ')) {
			session('bindQQ',null);
			//檢查QQ是否被綁定
			$qqarr=array('qq_openid'=>$openid);
				if ($user->findUser($qqarr)) {
				$this->error('此QQ已被綁定','index/index');
			}
			if (!session('user_openid')) {
				$this->error('請先登錄');
			}
			if ($user->bindQQ($qqarr)) {
				session('wxAutoLogin',null);
				$this->success('QQ綁定成功！','index/index');
			}else{
				$this->error('QQ綁定失敗!');
			}
		}
		
		//获取用户信息
		$arr=$qc->get_user_info();
		//将用户信息存入数据库
		$data=array('info'=>$arr,'openid'=>$openid);
		if ($user->qqSaveUser($data)) {
			$this->success('成功，正在返回首页！','index/index');
		}else{
			$this->error('数据写入失败！');
		}
	}

}