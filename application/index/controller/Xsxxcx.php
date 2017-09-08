<?php
namespace app\index\controller;
use Reptile\htmlDomParser;
use Reptile\Suse;
use Reptile\Jcc;
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

			//查询用户个人信息
			action('Xsxxcx/getPersonalInfo');

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
		$arr1 = $suse->getAchievement1();
		// var_dump($arr1);exit();
		//保存成绩信息
		$achievement1=model('Achievement');
		$achievement1->saveAchievement($arr1);

		$arr2 = $suse->getAchievement2();
		//保存成绩信息
		$achievement2=model('Achievement');
		$achievement2->updateAchievement($arr2);

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

	/**
	 * 成绩统计
	 * @return [type] [description]
	 */
	function achievementCount(){
		$suse = unserialize(session('suse'));
		$data=$suse->achievementCount();

		$credit_points=$data['res1'];
		$credit=$data['res2'];

		$credit_points_info=model('CreditPoints');
		$credit_points_info->saveCreditPointsInfo($credit_points);

		$credit_info=model('Credit');
		$credit_info->saveCreditInfo($credit);

		$this->redirect('index/showCredit');
	}

	/**
	 * 学号分析
	 * 通过输入学号信息，分析出专业班级，学院年级
	 * @return [type] [description]
	 */
	function studentIdAnalysis(){
		// $student_id='14101070205';
		$student_id=input('get.student_id');
		$grade=substr($student_id,0,2);
		switch ($grade) {
			case '14':
				$grade='大四老油条';
				break;
			case '15':
				$grade='大三';
				break;
			case '16':
				$grade='大二';
				break;
			case '17':
				$grade='大一小鲜肉';
				break;
			default:
				$grade='您已经毕业啦！';
				break;
		}
		$info=substr($student_id,2,7);
		$sql='select college,major,classes from tp5_student_info where student_id like __1010702__ limit 1';
		$student_info=model('StudentInfo');
		$res=$student_info->studentIdAnalysis($info);
		$res=json_decode(json_encode($res),true);
		$res['grade']=$grade;
		//拆分出班级号
		$arr=explode('2017', $res['classes']);
		$res['classes']=$arr['1'];
		$res=json_encode($res);
		return $res;
	}

	/**
	 * 获取个人信息
	 * @return [type] [description]
	 */
	function getPersonalInfo(){
		$suse = unserialize(session('suse'));

		$data=$suse->getPersonalInfo();

		$personal_info=model('PersonalInfo');
		$personal_info->savePersonalInfo($data);


		// var_dump($data);
	}

	/**
	 * 等级考试成绩查询
	 * @return [type] [description]
	 */
	function getExaminationInfo(){
		$suse = unserialize(session('suse'));

		$data=$suse->getExaminationInfo();

		// $personal_info=model('PersonalInfo');
		// $personal_info->savePersonalInfo($data);


		var_dump($data);
	}

	/**
	 * 获取考生地址
	 * @return [type] [description]
	 */
	function getAddress(){
		$suse=new Suse();
		
		$student_info=model('StudentInfo');
		$res=$student_info->getStudentId();		

		$res=json_decode(json_encode($res),true);

		foreach ($res as $key => $value) {
			$data=$suse->getAddress($value['number']);
			$student_info=model('StudentInfo');
			$student_info->updateStudentInfo($data);
		}

	}

	/**
	 * 模拟登陆计财处
	 * @return [type] [description]
	 */
	function jccLogin(){
		$act='';
		if (input('param.act')) {
		   $act = input('param.act');
		}

		$username = input('post.user');//用户名
		$password = input('post.password');//密码
		$code = input('post.ValidateCode');//验证码
		$jcc=new Jcc($username,$password,$code);
			


		if ($act=='login'){
			$content=$jcc->jccLogin();
			// session('suse',serialize($suse));
			$content=$jcc->getjccInfo();

			echo  $content;exit();
			// $this->redirect('index/suse');

		  }elseif ($act=='authcode') {
		      // Content-Type 验证码的图片类型
		      header('Content-Type:image/png charset=gb2312');
		      $jcc->showAuthcode();
		      exit;
		  }else{
		  	echo "no param";
		  }
	}


}