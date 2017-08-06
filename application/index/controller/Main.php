<?php
namespace app\index\controller;
use Yunpian\YunpianApi;
use PHPMailer\PHPMailer;
class Main extends \think\Controller{
	function __construct(){
		//
	}
	/*发送邮件*/
	function send_mail(){
		$email = trim($_POST['email']);	
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
		// $mail->addAddress('ellen@example.com');               // Name is optional
		$mail->addReplyTo(config('smtpusermail'), 'www.zhongyilove.com');
		// $mail->addCC('cc@example.com');
		// $mail->addBCC('bcc@example.com');

		// $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
		// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
		$mail->isHTML(true);                                  // Set email format to HTML
		$token=md5(time());
		$mail->Subject = '众一互联网用户注册邮箱验证';
		$mail->Body    = "亲爱的：<br/>感谢您在我站注册了新帐号。<br/>请点击链接激活您的帐号。<br/><a href='".config('reg_url')."?verify=".$token."' target='_blank'>http://www.helloweba.com/demo/register/active.php?verify=</a><br/>如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接24小时内有效。<br/>如果此次激活请求非你本人所发，请忽略本邮件。<br/><p style='text-align:right'>-------- Hellwoeba.com 敬上</p>";
		$mail->AltBody = '这是非html邮件客户机的纯文本';

		if(!$mail->send()) {
		    echo 'Message could not be sent.';
		    echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
		    echo 'Message has been sent';
		}

	}
	/*邮箱验证*/
	function bindMail(){
		//
		if (session('mail_token')!=input('get.token')) {
			# code...

		}
	}

	/*发送短信验证码*/
	function send_message(){
		//
		if (!empty(session('yunpian'))) {
			# code...
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


	/*用户手机号验证*/
	function bindPhone(){

		//判断验证码是否正确
		if(input('code')==session('yunpian.code') && !empty(input('code'))){
			//验证码超时判断
			if (time()-session('yunpian.time')>60) {
				$this->error('验证码超时，请重新获取');
			}
			//验证成功，则清除session
			session('yunpian.code','');
			$this->success('验证成功','index/index');
		}else{
			$this->error('验证失败');
		}
	}

	/*查看session的工具函数*/
	function session(){
		var_dump(session(''));
	}
}