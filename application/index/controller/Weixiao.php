<?php
namespace app\index\controller;
use WeiXiao\WeixiaoAppAccess;
use WeiXiao\MediaInfo;
class Weixiao {
	function index(){
		return json_encode(array(
                    'errcode' => 0,
                    'errmsg' => '',
                    'token' => '',
                    'is_config' =>1,
                ));
		// $weixiao=new WeixiaoAppAccess();
		// echo $weixiao->index();
		// $object = new MediaInfo();
		// $object->getInfo();
	}
}