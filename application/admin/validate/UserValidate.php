<?php
namespace app\index\validate;

class UserValidate extends \think\Validate{

	protected $rule = [
		'mobile'=>['require'],
		'email'=>['require','email'],
		//必须，长度6-20之间
		'account'=>['require','length:6,20'],
		//必须，只能是字母和数字，长度6-20之间
		'password'=>['require','alphaNum','length:6,20'],
	];

	protected $message = [
		'username.require'=>'账号必须填写',
	];

	protected $scene = [
		'genneral'=>'account,password',
		'mailreg'=>'email,password',
		'phonereg'=>'mobile,password',
		'bindmail'=>'email',
		'bindphone'=>'mobile',
	];
}