<?php
/*三种用户注册方式，普通账号注册，手机号码注册，邮箱注册*/
namespace app\index\controller;
use Yunpian\YunpianApi;
use PHPMailer\PHPMailer;
class User extends \think\Controller{

	/**
	 * 账号登录
	 * @return [type] [description]
	 */
	function login(){
		//处理表单数据
		$data['account']=input('post.account');
		$data['password']=input('post.password');
		$validate=validate('UserValidate');
		if (!$validate->scene('genneral')->check($data)) {
			$this->error($validate->getError());
		}
		//调用model
		$user=model('UserInfo');
		$res=$user->login($data);
		if (isset($res) && !empty($res)) {
			//将用户openid存session
			session('user_openid',$res['openid']);
			$this->success('登录成功','index/index');
		}else{
			$this->error('登录失败，账号或密码错误！');
		}
		
	}


	/**
	 * 手机登录
	 * @return [type] [description]
	 */
	function phoneLogin(){
		$phone=session('yunpian.phone');
		//判断验证码是否正确
		if(input('post.code')==session('yunpian.code') && !empty(input('post.code'))){
			//验证码超时判断
			if (time()-session('yunpian.time')>60) {
				session('yunpian',null);
				$this->error('验证码超时，请重新获取');
			}
			//验证成功，则清除手机验证码session
			session('yunpian',null);
			//检查手机号是否被注册
			$user=model('UserInfo');
			if ($res=$user->findUser(array('mobile'=>$phone))) {
				session('user_openid',$res['openid']);
				if ($user->upLoginInfo(array('mobile'=>$phone))) {
					$this->success('登录成功，正在返回首页！','index/index');
				}else{
					$this->error('更新最后登录信息失败！');
				}
			}else{
				$this->error('此手机号未注册！');
			}
		}else{
			$this->error('短信验证码错误！');
		}
	}
	
	/**
	 * 普通账号注册
	 * @return [type] [description]
	 */
	function register(){
		$data['state']=0;
		$data['account']=input('post.account');
		$data['password']=input('post.password');
		$validate=validate('UserValidate');
		if (!$validate->scene('genneral')->check($data)) {
			$this->error($validate->getError());
		}
		$user=model('UserInfo');
		if($user->findUser(array('account'=>$data['account']))){
			$this->error('用户已经存在！');
		}
		if ($user->register($data)) {
			$this->success('注册成功，正在返回首页！','index/index');
		}else{
			$this->error('数据写入失败！');
		}
	}

	/**
	 * 发送手机验证码
	 * @return [type] [description]
	 */
	function send_message(){
		if (!empty(session('yunpian'))) {
			session('yunpian',unll);
		}
		//获取ajax传递的phones值
		$phone=input('post.phone');
		//检查输入的手机号是否合法
		$isPhone=preg_match('/^(13\d|14[57]|15[^4,\D]|17[13678]|18\d)\d{8}|170[0589]\d{7}$/',$phone);
		if ($isPhone==0) {
			$arr['msg']='请输入正确的手机号';
			return $arr['msg'];
		}
		//发送验证码短信
		$send=new YunpianApi();
		$tpl='code1';
		$arr=$send->send_tpl($phone,$tpl);
		
		//如果返回状态码不为0，则返回错误信息
		if($arr['code']){
			return $arr['msg'];
		}
		//存储api创建的code
		session('yunpian',$arr['yunpian']);

	}

	/**
	 * 手机号注册，验证短信验证码
	 * @return [type] [description]
	 */
	function phoneReg(){
		//使用session获取phone防止用户提交时修改手机号
		$phone=session('yunpian.phone');
		//判断验证码是否正确
		if(input('post.code')==session('yunpian.code') && !empty(input('post.code'))){
			//验证码超时判断
			if (time()-session('yunpian.time')>60) {
				session('yunpian',null);
				$this->error('验证码超时，请重新获取');
			}
			//验证成功，则清除手机验证码session
			session('yunpian',null);
			//将注册信息写入数据库
			$user=model('UserInfo');
			$data['mobile']=$phone;
			$data['password']=input('post.password');

			//检验输入数据
			$validate=validate('UserValidate');
			if (!$validate->scene('phonereg')->check($data)) {
				$this->error($validate->getError());
			}
			//检查用户是否存在
			if($user->findUser(array('mobile'=>$data['mobile']))){
				$this->error('用户已经存在！');
			}
			//用户信息写入数据库
			if($user->phoneReg($data)){
				$this->success('注册成功，正在返回首页！','index/index');
			}else{
				$this->error('数据写入失败！');
			}
			
		}else{
			$this->error('验证码错误！');
		}
	}

	/**
	 * 绑定手机
	 * @return [type] [description]
	 */
	function bindPhone(){
		$phone=session('yunpian.phone');
		//前提是用户已经登录，获取用户的openid
		$user_openid=session('user_openid');
		if (empty($user_openid)) {
			session('yunpian',null);
			$this->error('请先登录');
		}
		//检查手机号是否被注册
		$user=model('UserInfo');
		if ($user->findUser(array('mobile'=>$phone))) {
			session('yunpian',null);
			$this->error('手机已经被其他账号绑定！');
		}
		//判断验证码是否正确
		if(input('post.code')==session('yunpian.code') && !empty(input('post.code'))){
			//验证码超时判断
			if (time()-session('yunpian.time')>60) {
				session('yunpian',null);
				$this->error('验证码超时，请重新获取');
			}
			//验证成功，则清除手机验证码session
			session('yunpian',null);
			//将绑定信息写入数据库
			$user=model('UserInfo');
			$data['mobile']=$phone;
			if ($user->bindPhone($data)) {
				$this->success('绑定成功，正在返回首页！','index/index');
			}else{
				$this->error('账号状态改变失败');
			}
			
		}else{
			$this->error('验证码错误！');
		}
	}
	

	/**
	 * 邮箱注册，发送激活邮件,将用户数据写入数据库
	 * @return [type] [description]
	 */
	function mailReg(){
		//检查邮箱是否被注册
		$user=model('UserInfo');
		if ($user->findUser(array('email'=>input('post.email')))) {
			$this->error('邮箱已经存在！');
		}

		$email = input('post.email');	
		$token=md5(time().rand(1000,9999));
		$mail = new PHPMailer;

		//调用common方法
		$arr['mailto']=$email;
		$arr['tpl']="mailReg";
		$arr['token']=$token;
		$res=init_mail($mail,$arr);

		if(!$mail->send()) {
		    $this->error($mail->ErrorInfo);
		} else {
			$data['email']=$email;
			$data['openid']=$token;
			$data['password']=input('post.password');
			
			if ($user->mailReg($data)) {
				$this->success('注册成功，正在返回首页！','index/index');
			}else{
				$this->error('数据写入失败！');
			}
		}

	}

	/**
	 * 绑定邮箱
	 * @return [type] [description]
	 */
	function bindMail(){
		$email=input('post.email');
		//确认用户已经登录，获取openid
		if (session($user_openid)) {
			$this->error('请先登录');
		}

		//检查输入邮箱是否合法
		$isMail = preg_match('/^\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}$/', $email);
		if ($isMail==0) {
			$this->error('请输入正确的邮箱');
		}
		//检查邮箱是否被绑定
		$user=model('UserInfo');
		if ($user->findUser(array('email'=>$email))) {
			$this->error('邮箱已经被绑定');
		}
		//发送激活邮件
		$email = input('post.email');	
		$mail = new PHPMailer;
		//调用common方法
		$arr['mailto']=$email;
		$arr['tpl']="mailReg";
		$arr['token']=$user_openid;
		$res=init_mail($mail,$arr);

		if(!$mail->send()) {
		    $this->error($mail->ErrorInfo);
		} else {
			$data['email']=$email;
			if ($user->bindMail($data)) {
				$this->success('激活邮件已经发送，请尽快激活，正在返回首页！','index/index');
			}else{
				$this->error('邮箱更新失败！');
			}
		}
	}
	/**
	 * 邮箱激活验证
	 * @return [type] [description]
	 */
	function verifyMail(){
		//
		$user=model('UserInfo');
		if (!$user->findUser(array('openid'=>input('get.verify')))) {
			$this->error('该用户不存在！');
		}
		if ($user->mailRegVarity(input('get.verify'))) {
			$this->success('邮箱激活成功，正在返回首页！','index/index');
		}else{
			$this->error('state邮箱激活失败！');
		}
	}


}
