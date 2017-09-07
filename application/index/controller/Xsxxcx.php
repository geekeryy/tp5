<?php
namespace app\index\controller;
use Reptile\htmlDomParser;
use Reptile\Suse;
class Xsxxcx extends \think\Controller{
	function studentLogin(){
		$act='';
		if (input('param.act')) {
		   $act = input('param.act');
		}
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
		$code = input('post.code');//验证码
		$suse=new Suse($user,$password,$code);
			
		session('user',$user);

		if ($act=='login'){
			$suse->curlLogin();
			session('suse',serialize($suse));
			//保存学生账号信息
			$suse_info=model('SuseInfo');
			$suse_info->saveSuse(array('student_id'=>$user,'password'=>$password));
			$this->redirect('index/suse');

		  }elseif ($act=='authcode') {
		      // Content-Type 验证码的图片类型
		      header('Content-Type:image/png charset=gb2312');
		      $suse->showAuthcode();
		      exit;
		  }else{
		  	echo "no param";
		  }
		   


	}


	/**
	 * 获取保存成绩信息
	 * @return [type] [description]
	 */
	function getAchievement(){
		$suse = unserialize(session('suse'));
		//获取成绩页面信息，返回成绩数组
		$arr = $suse->getAchievement();
		//保存成绩信息
		$achievement=model('Achievement');
		$achievement->saveAchievement($arr);

		$this->redirect('index/showAchievement');
	}

	/**
	 * 获取保存课程信息
	 * @return [type] [description]
	 */
	function getCourseInfo(){
		$suse = unserialize(session('suse'));
		
		//获取所有课程信息
		$data=$suse->getCourseInfo();

		//课程信息
		$res1=$data['res1'];
		//其它信息
		$res2=$data['res2'];

		$student_info=model('StudentInfo');
		$student_info->saveStudent($res2);

		$course_info=model('CourseInfo');
		$course_info->saveCourseInfo($res1,$res2);
					
		$this->redirect('index/showCourse');
	}


}