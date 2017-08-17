<?php
namespace WX;

class WX{

	const GET_OAUTH_CODE_URL ='https://open.weixin.qq.com/connect/oauth2/authorize?';
	const GET_ACCESS_TOKEN_URL ='https://api.weixin.qq.com/sns/oauth2/access_token?';
	const GET_USER_INFO_URL ='https://api.weixin.qq.com/sns/userinfo?';
	function __construct(){
	}
	/**
	 * snsapi_base 方式获取code
	 * 无需用户同意，即可获取
	 * @return [type] [description]
	 */
	function wxAutoLogin(){
		$url=self::GET_OAUTH_CODE_URL.'appid='.config("wx_appid").'&redirect_uri='.config("wx_callback").'&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect';
		return $url;
	}

	/**
	 * snsapi_userinfo方式拉起微信授权
	 * @return [type] [description]
	 */
	function wx_login(){
		$url=self::GET_OAUTH_CODE_URL.'appid='.config("wx_appid").'&redirect_uri='.config("wx_callback").'&response_type=code&scope='.config("wx_scope").'&state=STATE#wechat_redirect';
		return $url;
	}

	/**
	 * 获取登录授权access_token
	 * @param  [type] $code [description]
	 * @return [type]       [description]
	 */
	function getAccessToken($code){
		//2.获取code，请求access_token和openid
		$url=self::GET_ACCESS_TOKEN_URL.'appid='.config("wx_appid").'&secret='.config("wx_appsecret").'&code='.$code.'&grant_type=authorization_code ';
        //3.获得access_token和openid
        $res=$this->cURL($url);
        return $res;
	}

	/**
	 * 获取用户信息
	 * @param  [type] $code [description]
	 * @return [type]       [description]
	 */
	function getUserInfo($data){
        $access_token=$data['access_token'];
        $openid=$data['openid'];
        $url=self::GET_USER_INFO_URL.'access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN ';
        $res=$this->cURL($url);
        return $res;
	}


	/**
	 * curl工具函数
	 * @param  [type] $url [description]
	 * @return [type]      [description]
	 */
	function cURL($url){
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL,$url);
        $response =  curl_exec($ch);
        curl_close($ch);
        return json_decode($response,true);
	}
}