<?php
namespace YouZan;

class YouZanApi {
	function getToken(){

		//工具型应用oauth2.0授权获取token
		$client_id = "167c52b9d50b4d7700";//请填入有赞云控制台的应用client_id
		$client_secret = "31fc346579e9d432657213307fbdd964";//请填入有赞云控制台的应用client_secret
		$redirect_url = "fill your redirect_url";//请填入开发者后台所填写的回调地址，本示例中回调地址应指向本文件。

		$token = new YZGetTokenClient( $client_id , $client_secret );
		$type = 'oauth';//如要刷新access_token，type值为refresh_token
		$keys['code'] = $_GET['code'];//如要刷新access_token，这里为$keys['refresh_token']
		$keys['redirect_uri'] = $redirect_url;

		echo '<pre>';
		var_dump(
		    $token->get_token( $type , $keys )
		);
		echo '</pre>';
	}
}