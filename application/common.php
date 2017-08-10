<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * 使对应导航栏高亮
 * @param  [type] $str [description]
 * @param  [type] $fun [description]
 * @return [type]      [description]
 */
function aside($str,$fun){
	if ($str==$fun) {
		echo 'class="fh5co-active"';
	}
	
}

/**
 * 显示对应用户头像
 * @param  [type] $logo [description]
 * @return [type]       [description]
 */
function logo($logo){
	if ($logo=session('img_url')) {
		echo 'src="'.$logo.'"';
	}else{
		echo 'src="__static__/images/logo-colored.png"';
	}
}

/**
 * 初始化邮件发送函数
 * @param  [type] $mail [description]
 * @param  [type] $data [description]
 * @return [type]       [description]
 */
function init_mail($mail,$data){

		$mailto=$data['mailto'];
		$tpl=$data['tpl'];
		

		// $mail->SMTPDebug = 3;                               // Enable verbose debug output
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = config('smtpserver');  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = config('smtpusermail');                 // SMTP username
		$mail->Password = config('smtppass');                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = config('smtpserverport');                                    // TCP port to connect to
		$mail->setFrom(config('smtpusermail'), 'www.zhongyilove.com');
		$mail->addAddress($mailto, 'User');     // Add a recipient
		$mail->addReplyTo(config('smtpusermail'), 'www.zhongyilove.com');//回复邮件地址
		$mail->isHTML(true);    
		switch ($tpl) {
			case 'mailReg':
				$token=$data['token'];
				$mail->Subject = '众一互联网用户注册邮箱验证';
				$mail->Body    = "亲爱的：".$mailto."<br/>感谢您在我站注册了新帐号。<br/>请点击链接激活您的帐号。<br/><a href='".config('reg_url')."?verify=".$token."' target='_blank'>".config('reg_url')."?verify=".$token."</a><br/>如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接24小时内有效。<br/>如果此次激活请求非你本人所发，请忽略本邮件。<br/><p style='text-align:right'>-------- www.jiangyang.me 敬上</p>";
				$mail->AltBody = '这是非html邮件客户机的纯文本';
				break;

			case 'suggest':
				$content=$data['content'];
				$mail->Subject = '邀请您参与《用户体验改善计划》';
				$mail->Body    = "亲爱的：".$mailto."<br/>您发送 的内容是：".$content."<br/><p></p>";
				$mail->AltBody = '这是非html邮件客户机的纯文本';
				break;
			case 'suggest2':
				$mail->Subject = '邀请您参与《用户体验改善计划》';
				$mail->Body    = "亲爱的：".$mailto."<br/>感谢您使用本网站。<br/>本站诚恳的邀请您参与我们的用户体验改善计划<br/>点击链接即可参与<br><a href='".config('reg_url')."?verify=".$token."' target='_blank'>".config('reg_url')."?verify=".$token."</a><br/>如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接24小时内有效。<br/><p style='text-align:right'>-------- www.jiangyang.me 敬上</p>";
				$mail->AltBody = '这是非html邮件客户机的纯文本';
				break;
			default:
				# code...
				break;
		}
		return $mail;
}