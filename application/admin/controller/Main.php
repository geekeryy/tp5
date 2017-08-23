<?php
namespace app\admin\controller;
use Yunpian\YunpianApi;
use PHPMailer\PHPMailer;
class Main extends \think\Controller{

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