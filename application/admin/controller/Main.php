<?php
namespace app\admin\controller;
use Yunpian\YunpianApi;
use PHPMailer\PHPMailer;
class Main extends \think\Controller{
	function test(){
// 		<?php

// return [

//     // +----------------------------------------------------------------------
//     // | 微信支付配置
//     // +----------------------------------------------------------------------
//     //SDK路径
//     'wxpay_path'=>APP_PATH.'../extend/WxpayAPI/',
//     //异步回调地址
//     'notify_url'=>'http://www.jiangyang.me/index/Wxpay/notify',

//     // +----------------------------------------------------------------------
//     // | 微信登录配置
//     // +----------------------------------------------------------------------

//     // 微信登录回调域名
//     'wx_callback'          => 'http://www.jiangyang.me/index/oauth/wx_callback',
//     // 微信登录appid
//     'wx_appid'             =>'wxba7464d31a8fd9b9',
//     // 信登录appkey
//     'wx_appsecret'         =>'ee85e8859022b23ff6139ce5d4912d20',
//     // wx_scope
//     'wx_scope'             =>'snsapi_userinfo',

//     // +----------------------------------------------------------------------
//     // | 微信JSSDK配置
//     // +----------------------------------------------------------------------

//     // ticket路径
//     'ticket_path'          => APP_PATH.'../extend/WX/',

//     // +----------------------------------------------------------------------
//     // | QQ登录配置
//     // +----------------------------------------------------------------------

//     // QQ登录回调域名
//     // 'qq_callback'          => 'http://localhost/thinkphp_5.0.10_full/public/index/oauth/callback.html',
//     'qq_callback'          => 'http://www.jiangyang.me/index/oauth/callback.html',
//     // QQ登录appid
//     'qq_appid'             =>'101401381',
//     //QQ登录appkey
//     'qq_appkey'            =>'1aca1a19c97cb66f2fcbc38120898583',
//     //scope
//     'qq_scope'             =>'get_user_info',
//     //errorReport
//     'qq_errorReport'       =>true,
//     //storageType
//     'qq_storageType'       =>'file',
//     // +----------------------------------------------------------------------
//     // | 云片网短信API
//     // +----------------------------------------------------------------------
//     'yunpian_apikey'       =>'70777a9cca857a65f0341d6371a7ad29',

//     // +----------------------------------------------------------------------
//     // | smtp邮箱服务器
//     // +----------------------------------------------------------------------

//     //邮件中注册链接
//     'reg_url'=>'http://www.jiangyang.me/index/user/verifyMail',
//      //SMTP服务器
//     'smtpserver' => 'smtp.exmail.qq.com',
//     //SMTP服务器端口
//     'smtpserverport' => 25, 
//     //SMTP服务器的用户邮箱
//     'smtpusermail' => 'jy@zhongyilove.com', 
//     //SMTP服务器的用户帐号
//     'smtpuser' => 'jy@zhongyilove.com', 
//     //SMTP服务器的用户密码
//     'smtppass' => 'Aa1126254578', 
    
// ];

		return 'ok';
	}

	function studentList(){
		//若不存在页码，则默认为1
        if (input('get.pn')) {
            $pn=input('get.pn');
        }else{
            $pn=1;
        }

        $student=model('StudentInfo');
        if (session('per')) {
            $per=session('per');
        }else{
            //默认每页20条数据
            $per=20;
        }
        //存在content则为搜索
        if (input('get.content') || session('content') ) {
        	if (input('get.content')) {
        		session('content',input('get.content'));
        	}
            $list=$student->search(session('content'),$pn,$per);
            $total=$student->total(session('content'));
        }else{
            $list=$student->show($pn,$per);
            $total=$student->total();
        }
        $list=json_decode(json_encode($list),true);

         //只要有小数部分，直接加一
        $total=ceil($total/$per);

        $data['list']=$list;
        $data['total']=$total;
        $data['pn']=$pn;
        $data['per']=$per;

        return $data;
	}

	function per(){
		session('per',input('get.per'));
		$this->redirect('index/tablelist');
	}
	function clear(){
		session('content',null);
		$this->redirect('index/tablelist');
	}

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
			echo $value1['state'].':'.$value1['data'].':'.$value1['tag'].':'.$value1['time'];
			echo '<br>';
		}
		var_dump(session(''));
		echo "</pre>";
	
	}
	function info($data){
		echo "<pre>";
		var_dump($data);
		echo "</pre>";
	}
}