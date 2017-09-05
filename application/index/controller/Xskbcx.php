<?php
namespace app\index\controller;
use Reptile\htmlDomParser;
use Reptile\Suse;
class Xskbcx extends \think\Controller{
	function studentLogin(){
		$act='';
		if (input('param.act')) {
		   $act = input('param.act');
		}
	// 15111040122
	// shenxin19971211
	// 
	// 15111040116
	// aspire1998
	// 
	// 15111040134
	// 526982371bx
	
		// $user = '14101070205';//用户名
		// $password = 'a1126254578';//密码
		
		// $user = '15111040122';//用户名
		// $password = 'shenxin19971211';//密码
		
		// $user = '15111040116';//用户名
		// $password = 'aspire1998';//密码

		// $user = '15111040134';//用户名
		// $password = '526982371bx';//密码

		$user = input('post.user');//用户名
		$password = input('post.password');//密码

		$suse=new Suse($user,$password);

		switch($act)
		{
		  case 'login':
		  //获取隐藏字段
		  	$suse->getViewstate();
		  //模拟登陆
			$suse->curlLogin();
		  //获取页面信息
		    $content = $suse->getContent();

			$hdp = new htmlDomParser();
			$html=$hdp->str_get_html($content);//创建DOM

			//获取学生信息
			$res1=$suse->getSomeInfo($html);

			$student_info=model('StudentInfo');
			$student_info->saveStudent($res1);

			//获取所有课程信息
			$res2=$suse->getAllCourse($html);	

			$course_info=model('CourseInfo');
			$course_info->saveCourseInfo($res2,$res1);
			
			session('student_id',input('post.user'));
			$this->redirect('index/showCourse');
		      break;
		   case 'authcode':
		      // Content-Type 验证码的图片类型
		      header('Content-Type:image/png charset=gb2312');
		      $suse->showAuthcode();
		      exit;
		     break;
		}


	}


}