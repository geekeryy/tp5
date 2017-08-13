<?php
namespace app\index\controller;
use Yunpian\YunpianApi;
use PHPMailer\PHPMailer;
class Main extends \think\Controller{
	

	/**
	 * 发送邮件
	 * @return [type] [description]
	 */
	function send_mail(){
		$email = trim(input('post.email'));	
		$content = trim(input('post.content'));
		$mail = new PHPMailer;
		//调用common方法
		$arr['mailto']=$email;
		$arr['tpl']="suggest";
		$arr['content']=$content;
		$res=init_mail($mail,$arr);

		if(!$res) {
		    echo 'Message could not be sent.';
		    echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
		    echo 'Message has been sent';
		}

	}


	/**
	 * 查看session的工具函数
	 * @return [type] [description]
	 */
	function session(){
		$test=model('Test');
		$res=$test->show();
		echo "<pre>";
		foreach ($res as $key1 => $value1) {
			echo $value1['state'].':'.$value1['tag'].':'.$value1['time'];
			echo '<br>';
		}
		var_dump(session(''));
		echo "</pre>";
		

	}
}