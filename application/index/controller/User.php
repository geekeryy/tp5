<?php
namespace app\index\controller;
use Yunpian\YunpianApi;
use PHPMailer\PHPMailer;
class User extends \think\Controller{
	//

	/*手机号注册,发送手机验证码*/
	function send_message(){
		if (!empty(session('yunpian'))) {
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

	/*手机号注册，用户手机号验证*/
	function bindPhone(){

		//判断验证码是否正确
		if(input('post.code')==session('yunpian.code') && !empty(input('post.code'))){
			//验证码超时判断
			if (time()-session('yunpian.time')>60) {
				$this->error('验证码超时，请重新获取');
			}
			//验证成功，则清除session
			session('yunpian.code','');
			//将注册信息写入数据库
			$user=model('UserInfo');
			$data['mobile']=input('post.phone');
			$data['password']=input('post.password');
			$res=$user->phoneReg($data);
			if($res){
				$this->redirect('index/index');
			}else{
				$this->error('写入数据库失败!');
			}
		}else{
			$this->error('验证失败');
		}
	}

	/*邮箱注册*/
	function mailReg(){
		$email = trim(input('post.email'));	
		$mail = new PHPMailer;
		// $mail->SMTPDebug = 3;                               // Enable verbose debug output
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = config('smtpserver');  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = config('smtpusermail');                 // SMTP username
		$mail->Password = config('smtppass');                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = config('smtpserverport');                                    // TCP port to connect to
		$mail->setFrom(config('smtpusermail'), 'www.zhongyilove.com');
		$mail->addAddress($email, 'Joe User');     // Add a recipient
		$mail->addReplyTo(config('smtpusermail'), 'www.zhongyilove.com');
		$mail->isHTML(true);                                  // Set email format to HTML
		$token=md5(time().rand(100,999));
		//区别于openid
		$token=substr($token, 2);
		$mail->Subject = '众一互联网用户注册邮箱验证';
		$mail->Body    = "亲爱的：<br/>感谢您在我站注册了新帐号。<br/>请点击链接激活您的帐号。<br/><a href='".config('reg_url')."?verify=".$token."' target='_blank'>".config('reg_url')."?verify=".$token."</a><br/>如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接24小时内有效。<br/>如果此次激活请求非你本人所发，请忽略本邮件。<br/><p style='text-align:right'>-------- www.jiangyang.me 敬上</p>";
		$mail->AltBody = '这是非html邮件客户机的纯文本';

		if(!$mail->send()) {
		    $this->error($mail->ErrorInfo);
		} else {
			$data['email']=$email;
			$data['openid']=$token;
			$data['password']=input('post.password');
			$user=model('UserInfo');
			$res=$user->mailReg($data);
			if($res){
				$this->redirect('index/wait');
			}else{
				$this->error('失败!');
			}
		    
		}

	}
	/*邮箱验证*/
	function bindMail(){
		//
		$user=model('UserInfo');
		$res=$user->mailRegVarity(input('get.verify'));
		if (isset($res) && !empty($res)) {
			$this->redirect('index/index');
		}
	}

}