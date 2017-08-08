<?php
/*三种用户注册方式，普通账号注册，手机号码注册，邮箱注册*/
namespace app\index\controller;
use Yunpian\YunpianApi;
use PHPMailer\PHPMailer;
class User extends \think\Controller{
	
	/*普通账号注册*/
	function register(){
		//
		$data['account']=input('post.account');
		$data['password']=input('post.password');
		$user=model('UserInfo');
		$res=$user->register($data);

		switch ($res) {
			case 0:
				$this->error('数据写入失败！');
				break;
			case 1:
				$this->success('注册成功，正在返回首页！','index/index');
				break;
			default:
				$this->error('用户已经存在！');
				break;
		}
	}

	/*发送手机验证码*/
	function send_message(){
		if (!empty(session('yunpian'))) {
			session('yunpian','');
		}
		//获取ajax传递的phones值
		$phones=input('post.phones');
		//发送验证码短信
		$send=new YunpianApi();
		$tpl='code';
		$arr=$send->send_tpl($phones,$tpl);
		//如果返回状态码不为0，则返回错误信息
		if($arr['code']){
			return $arr['msg'];
		}
		//存储api创建的code
		session('yunpian',$arr['yunpian']);
	}

	/*手机号注册*/
	function phoneReg(){

		//判断验证码是否正确
		if(input('post.code')==session('yunpian.code') && !empty(input('post.code'))){
			//验证码超时判断
			if (time()-session('yunpian.time')>60) {
				$this->error('验证码超时，请重新获取');
			}
			//验证成功，则清除手机验证码session
			session('yunpian.code','');
			//将注册信息写入数据库
			$user=model('UserInfo');
			$data['mobile']=input('post.phone');
			$data['password']=input('post.password');
			$res=$user->phoneReg($data);
			switch ($res) {
				case 0:
					$this->error('数据写入失败！');
					break;
				case 1:
					$this->success('注册成功，正在返回首页！','index/index');
					break;
				default:
					$this->error('用户已经存在！');
					break;
			}
		}else{
			$this->error('验证码错误！');
		}
	}

	/*邮箱注册*/
	function mailReg(){
		$user=model('UserInfo');
		$res=$user->findUser(array('email'=>input('post.email')));
		if (isset($res) && !empty($res)) {
			//存在用户
			$this->error('用户已经存在！');
		}

		$email = trim(input('post.email'));	
		$token=md5(time().rand(100,999));
		$mail = new PHPMailer;

		//调用common方法
		$arr['mailto']=$email;
		$arr['tpl']="mailReg";
		$arr['token']=$token;
		$mail=init_mail($mail,$arr);

		if(!$mail->send()) {
		    $this->error($mail->ErrorInfo);
		} else {
			$data['email']=$email;
			$data['openid']=$token;
			$data['password']=input('post.password');
			
			$res=$user->mailReg($data);
			switch ($res) {
				case 0:
					$this->error('数据写入失败！');
					break;
				case 1:
					$this->success('注册成功，正在返回首页！','index/index');
					break;
				default:
					$this->error('未知错误!');
					break;
			}
		    
		}

	}
	/*邮箱激活验证*/
	function bindMail(){
		//
		$user=model('UserInfo');
		$res=$user->mailRegVarity(input('get.verify'));
		switch ($res) {
				case 0:
					$this->error('数据写入失败！');
					break;
				case 1:
					$this->success('邮箱激活成功，正在返回首页！','index/index');
					break;
				default:
					$this->error('该用户不存在！');
					break;
			}
	}

}