<?php
namespace Reptile;
class Suse{

	private $url='http://61.139.105.138/default2.aspx';
	private $authcode_url='http://61.139.105.138/CheckCode.aspx';
	private $xm;
	private $cookieFile;
	private $user;
	private $password;
	private $code;

	//请求参数
	private $param;

	//成绩查询2
	const XSCJCX='http://61.139.105.138/xscjcx.aspx?';
	//成绩查询1
	const XSCJCX_DQ='http://61.139.105.138/xscjcx_dq.aspx?';

	const XSMAIN='http://61.139.105.138/xs_main.aspx?';
	const XSKBCX='http://61.139.105.138/xskbcx.aspx?';
	const XSGRXX='http://61.139.105.138/xsgrxx.aspx?';
	const XSDJKSCX='http://61.139.105.138/xsdjkscx.aspx?';
	function __construct($user='',$password='',$code=''){
		$this->user=$user;
		$this->password=$password;
		$this->code=$code;
		$this->cookieFile=APP_PATH.'../runtime/cookie'.session_id().'.tmp';
	}

	/**
	 * 执行模拟登陆教务管理系统，保存名字信息
	 * @return [type] [description]
	 */
	function curlLogin()
	{ 

	// 获取登陆所需的viewstate
		$ch1 = curl_init($this->url);
		curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);//0获取后直接打印出来
	    $content =curl_exec($ch1);
	    curl_close($ch1);
	    $hdp = new htmlDomParser();	
		$html=$hdp->str_get_html($content);//创建DOM
		$e=$html->find('input',0);
		$viewstate=$e->value;
		unset($hdp);

		// $loginParams为curl模拟登录时post的参数
		$this->loginParams['__VIEWSTATE'] = $viewstate;
		$this->loginParams['RadioButtonList1'] = '学生';
		$this->loginParams['TextBox2'] = $this->password;
		$this->loginParams['txtUserName'] = $this->user;
		$this->loginParams['Button1'] = '';
		$this->loginParams['lbLanguage'] = '';
		$this->loginParams['hidPdrs'] = '';
		$this->loginParams['hidsc'] = '';
		$this->loginParams['txtSecretCode'] = $this->code; 
	    $ch = curl_init($this->url);
	    curl_setopt($ch,CURLOPT_COOKIEFILE, $this->cookieFile); //同时发送Cookie
	    curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);//设定返回的数据是否自动显示
	    curl_setopt($ch, CURLOPT_HEADER, 0);//设定是否显示头信 息
	    curl_setopt($ch, CURLOPT_NOBODY, false);//设定是否输出页面 内容
	    curl_setopt($ch,CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	    curl_setopt($ch,CURLOPT_POSTFIELDS, $this->loginParams); //提交查询信息
	    $content=curl_exec($ch);//返回结果
	    curl_close($ch); //关闭

	    $hdp = new htmlDomParser();	
		$html=$hdp->str_get_html($content);//创建DOM
		$e=$html->find('#xhxm',0);
		if ($e=='') {
			return 'error';
		}
		$name=substr($e->innertext(), 0,-4);
	    
		$this->xm=$name;
	    return $name;
	}



	/**
	 * 返回所有课表信息以及其它信息
	 * 工具函数
	 * @param  [type] $html [description]
	 * @return [type]       [description]
	 */
	function getAllCourse($content){

		$hdp = new htmlDomParser();
		$html=$hdp->str_get_html($content);//创建DOM

		$data=array();
		$i=0;
		$res1=array();
		$item=$html->find('#Table1 tr');
		foreach ($item as $value1) {
			foreach ($value1->find('td') as $value2) {
				if (strstr($value2->innertext(),'<br>')) {
					$res1[$i]=explode('<br>',$value2->innertext());
					$i++;
				}
			}
		}

		//课程数组
		$data['res1']=$res1;

			$info=array();
			$xnd=$html->find('#xnd option[selected=selected]',0);
			$info['year']=$xnd->value;

			$xqd=$html->find('#xqd option[selected=selected]',0);
			$info['semester']=$xqd->value ;

			$xh=$html->find('#Label5',0);
			$arr=explode('：', $xh->innertext());
			$info['student_id']=$arr[1];

			$xm=$html->find('#Label6',0);
			$arr=explode('：', $xm->innertext());
			$info['name']=$arr[1];

			$xy=$html->find('#Label7',0);
			$arr=explode('：', $xy->innertext());
			$info['college']=$arr[1];

			$zy=$html->find('#Label8',0);
			$arr=explode('：', $zy->innertext());
			$info['major']=$arr[1];

			$bj=$html->find('#Label9',0);
			$arr=explode('：', $bj->innertext());
			$info['classes']=$arr[1];
		//姓名，班级信息数组
		$data['res2']=$info;

		return $data;
	}

	/**
	 * 学生课表查询，获取课表页面
	 * @return [type] [description]
	 */
	function getCourseInfo(){
		$curl2=curl_init();
	    curl_setopt ($curl2,CURLOPT_REFERER,self::XSMAIN.'xh='.$this->user);//.'#a'
	    curl_setopt($curl2, CURLOPT_COOKIEFILE, $this->cookieFile); 
	    curl_setopt($curl2, CURLOPT_HEADER, false); 
	    curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true); 
	    curl_setopt($curl2, CURLOPT_TIMEOUT, 20); 
	    curl_setopt($curl2, CURLOPT_AUTOREFERER, true); 
	    curl_setopt($curl2, CURLOPT_FOLLOWLOCATION, true); 

	    curl_setopt($curl2, CURLOPT_URL, self::XSKBCX.'xh='.$this->user.'&xm='.$this->xm.'&gnmkdm=N121603');
	    //登陆后要从哪个页面获取信息

	    //http://61.139.105.138/xskbcx.aspx?xh=14101070205&xm=%BD%AD%D1%EE&gnmkdm=N121603

	    $en_contents=mb_convert_encoding( curl_exec($curl2),'utf-8', array('Unicode','ASCII','GB2312','GBK','UTF-8'));

	    curl_close($curl2);

		return $this->getAllCourse($en_contents);

	}
	/**
	 * 成绩查询1
	 * 返回成绩数组
	 * @return [type] [description]
	 */
	function getAchievement1(){


	//构造成绩查询1所需参数
		// http://61.139.105.138/xscjcx_dq.aspx?xh=14101070205&xm=%BD%AD%D1%EE&gnmkdm=N121605
		$curl1=curl_init();
	    curl_setopt ($curl1,CURLOPT_REFERER,self::XSMAIN.'xh='.$this->user);//.'#a'
	    curl_setopt($curl1, CURLOPT_COOKIEFILE, $this->cookieFile); 
	    curl_setopt($curl1, CURLOPT_HEADER, false); 
	    curl_setopt($curl1, CURLOPT_RETURNTRANSFER, true); 
	    curl_setopt($curl1, CURLOPT_TIMEOUT, 20); 
	    curl_setopt($curl1, CURLOPT_AUTOREFERER, true); 
	    curl_setopt($curl1, CURLOPT_FOLLOWLOCATION, true); 
	    curl_setopt($curl1, CURLOPT_URL, self::XSCJCX_DQ.'xh='.$this->user.'&xm='.$this->xm.'&gnmkdm=N121605');
	     //登陆后要从哪个页面获取信息
		$content=curl_exec($curl1);
	    curl_close($curl1);

	    $hdp = new htmlDomParser();	
		$html=$hdp->str_get_html($content);//创建DOM
		$e=$html->find('#Form1 input[type=hidden]',2);

		$this->param['__EVENTTARGET']='';
		$this->param['__EVENTARGUMENT']='';
		$this->param['__VIEWSTATE']=$e->value;
		$this->param['btnCx']=' 查  询 ';
		$this->param['ddlxn']='';
		$this->param['ddlxq']='';
		unset($hdp);

	//获取成绩查询1的成绩信息
		// http://61.139.105.138/xscjcx.aspx?xh=14101070205&xm=%BD%AD%D1%EE&gnmkdm=N121618
		$curl2=curl_init();
	    curl_setopt ($curl2,CURLOPT_REFERER,self::XSMAIN.'xh='.$this->user);//.'#a'
	    curl_setopt($curl2, CURLOPT_COOKIEFILE, $this->cookieFile); 
	    curl_setopt($curl2, CURLOPT_HEADER, false); 
	    curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true); 
	    curl_setopt($curl2, CURLOPT_TIMEOUT, 20); 
	    curl_setopt($curl2, CURLOPT_AUTOREFERER, true); 
	    curl_setopt($curl2, CURLOPT_FOLLOWLOCATION, true); 
	    curl_setopt($curl2,CURLOPT_POSTFIELDS, $this->param); //提交查询信息
	    curl_setopt($curl2, CURLOPT_URL, self::XSCJCX_DQ.'xh='.$this->user.'&xm='.$this->xm.'&gnmkdm=N121605');
	     //登陆后要从哪个页面获取信息

	     $content=mb_convert_encoding( curl_exec($curl2),'utf-8', array('Unicode','ASCII','GB2312','GBK','UTF-8'));
	     curl_close($curl2);

	    $hdp = new htmlDomParser();	
		$html=$hdp->str_get_html($content);//创建DOM
		$e=$html->find('#DataGrid1 tr');
		$arr=array();
		$ach_info=array();
		array_shift($e);
		$i=0;
		foreach ($e as $value1) {
			$ach_info[$i]['student_id']=$this->user;
			$ach_info[$i]['year'] = $value1->find('td',0)->innertext();
			$ach_info[$i]['semester'] = $value1->find('td',1)->innertext();
			$ach_info[$i]['course_id'] = $value1->find('td',2)->innertext();
			$ach_info[$i]['course_name'] = $value1->find('td',3)->innertext();
			$ach_info[$i]['course_type'] = $value1->find('td',4)->innertext();
			$ach_info[$i]['course_ascription'] = $value1->find('td',5)->innertext();
			$ach_info[$i]['credit'] = $value1->find('td',6)->innertext();
			$ach_info[$i]['peacetime_ach'] = $value1->find('td',7)->innertext();
			$ach_info[$i]['midterm_ach'] = $value1->find('td',8)->innertext();
			$ach_info[$i]['final_ach'] = $value1->find('td',9)->innertext();
			$ach_info[$i]['experiment_ach'] = $value1->find('td',10)->innertext();
			$ach_info[$i]['achievement'] = $value1->find('td',11)->innertext();
			$ach_info[$i]['makeup_ach'] = $value1->find('td',12)->innertext();
			$ach_info[$i]['repair_remarks'] = $value1->find('td',13)->innertext();
			$ach_info[$i]['college'] = $value1->find('td',14)->innertext();
			$ach_info[$i]['remarks'] = $value1->find('td',15)->innertext();
			$ach_info[$i]['makeup_remarks'] = $value1->find('td',16)->innertext();
			$i++;
		}
		return $ach_info;
	}

	/**
	 * 获取成绩查询2页面的隐藏字段
	 * @return [type] [description]
	 */
	function getViewState(){
		// http://61.139.105.138/xscjcx_dq.aspx?xh=14101070205&xm=%BD%AD%D1%EE&gnmkdm=N121605
		$curl2=curl_init();
	    curl_setopt ($curl2,CURLOPT_REFERER,self::XSMAIN.'xh='.$this->user);//.'#a'
	    curl_setopt($curl2, CURLOPT_COOKIEFILE, $this->cookieFile); 
	    curl_setopt($curl2, CURLOPT_HEADER, false); 
	    curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true); 
	    curl_setopt($curl2, CURLOPT_TIMEOUT, 20); 
	    curl_setopt($curl2, CURLOPT_AUTOREFERER, true); 
	    curl_setopt($curl2, CURLOPT_FOLLOWLOCATION, true); 
	    curl_setopt($curl2, CURLOPT_URL, self::XSCJCX.'xh='.$this->user.'&xm='.$this->xm.'&gnmkdm=N121618');
	     //登陆后要从哪个页面获取信息
		$content=curl_exec($curl2);
	    curl_close($curl2);

	    $hdp = new htmlDomParser();	
		$html=$hdp->str_get_html($content);//创建DOM
		$e=$html->find('#Form1 input[type=hidden]',2);

		$this->param['__EVENTTARGET']='';
		$this->param['__EVENTARGUMENT']='';
		$this->param['__VIEWSTATE']=$e->value;
		$this->param['btn_zcj']='历年成绩';
		$this->param['ddlXN']='';
		$this->param['ddlXQ']='';
		$this->param['ddl_kcxz']='';
		$this->param['hidLanguage']='';
		unset($hdp);
		return $this->param;
	}

	/**
	 * 成绩查询2
	 * 返回成绩数组
	 * @return [type] [description]
	 */
	function getAchievement2(){
		//获取隐藏字段
		$this->getViewState();

	//获取成绩信息
		// http://61.139.105.138/xscjcx.aspx?xh=14101070205&xm=%BD%AD%D1%EE&gnmkdm=N121618
		$curl2=curl_init();
	    curl_setopt ($curl2,CURLOPT_REFERER,self::XSMAIN.'xh='.$this->user);//.'#a'
	    curl_setopt($curl2, CURLOPT_COOKIEFILE, $this->cookieFile); 
	    curl_setopt($curl2, CURLOPT_HEADER, false); 
	    curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true); 
	    curl_setopt($curl2, CURLOPT_TIMEOUT, 20); 
	    curl_setopt($curl2, CURLOPT_AUTOREFERER, true); 
	    curl_setopt($curl2, CURLOPT_FOLLOWLOCATION, true); 
	    curl_setopt($curl2,CURLOPT_POSTFIELDS, $this->param); //提交查询信息
	    curl_setopt($curl2, CURLOPT_URL, self::XSCJCX.'xh='.$this->user.'&xm='.$this->xm.'&gnmkdm=N121618');
	     //登陆后要从哪个页面获取信息

	     $content=mb_convert_encoding( curl_exec($curl2),'utf-8', array('Unicode','ASCII','GB2312','GBK','UTF-8'));
		// $content=curl_exec($curl2);
	     curl_close($curl2);

	    $hdp = new htmlDomParser();	
		$html=$hdp->str_get_html($content);//创建DOM

		$e=$html->find('#Datagrid1 tr');
		$arr=array();
		$ach_info=array();
		//删除数组第一个元素
		array_shift($e);
		$i=0;
		foreach ($e as $value1) {
			$ach_info[$i]['student_id']=$this->user;
			// $ach_info[$i]['year'] = $value1->find('td',0)->innertext();
			// $ach_info[$i]['semester'] = $value1->find('td',1)->innertext();
			$ach_info[$i]['course_id'] = $value1->find('td',2)->innertext();
			// $ach_info[$i]['course_name'] = $value1->find('td',3)->innertext();
			// $ach_info[$i]['course_type'] = $value1->find('td',4)->innertext();
			// $ach_info[$i]['course_ascription'] = $value1->find('td',5)->innertext();
			// $ach_info[$i]['credit'] = $value1->find('td',6)->innertext();
			$ach_info[$i]['point'] = $value1->find('td',7)->innertext();
			// $ach_info[$i]['achievement'] = $value1->find('td',8)->innertext();
			$ach_info[$i]['minor_remarks'] = $value1->find('td',9)->innertext();
			// $ach_info[$i]['makeup_ach'] = $value1->find('td',10)->innertext();
			$ach_info[$i]['repair_ach'] = $value1->find('td',11)->innertext();
			// $ach_info[$i]['college'] = $value1->find('td',12)->innertext();
			// $ach_info[$i]['remarks'] = $value1->find('td',13)->innertext();
			// $ach_info[$i]['repair_remarks'] = $value1->find('td',14)->innertext();
			$i++;
		}

	     return $ach_info;
	}


	/**
	 * 获取成绩统计信息
	 * @return [type] [description]
	 */
	function achievementCount(){
		//获取隐藏字段参数
		$this->getViewState();
		$this->param['Button1']='成绩统计';
		// http://61.139.105.138/xscjcx.aspx?xh=14101070205&xm=%BD%AD%D1%EE&gnmkdm=N121618
		$curl2=curl_init();
	    curl_setopt ($curl2,CURLOPT_REFERER,self::XSMAIN.'xh='.$this->user);//.'#a'
	    curl_setopt($curl2, CURLOPT_COOKIEFILE, $this->cookieFile); 
	    curl_setopt($curl2, CURLOPT_HEADER, false); 
	    curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true); 
	    curl_setopt($curl2, CURLOPT_TIMEOUT, 20); 
	    curl_setopt($curl2, CURLOPT_AUTOREFERER, true); 
	    curl_setopt($curl2, CURLOPT_FOLLOWLOCATION, true); 
	    curl_setopt($curl2,CURLOPT_POSTFIELDS, $this->param); //提交查询信息
	    curl_setopt($curl2, CURLOPT_URL, self::XSCJCX.'xh='.$this->user.'&xm='.$this->xm.'&gnmkdm=N121618');
	     //登陆后要从哪个页面获取信息

	     $content=mb_convert_encoding( curl_exec($curl2),'utf-8', array('Unicode','ASCII','GB2312','GBK','UTF-8'));
		// $content=curl_exec($curl2);
	     curl_close($curl2);

	    $hdp = new htmlDomParser();	
		$html=$hdp->str_get_html($content);//创建DOM

		$xftj=$html->find('#xftj',0);
		$arr=explode('；', $xftj->innertext());

		$data1['student_id']=$this->user;
		$data1['credit_select']=preg_replace('/[^\d.]/s', '',$arr['0']);
		$data1['credit_all_get']=preg_replace('/[^\d.]/s', '',$arr['1']);
		$data1['credit_repair']=preg_replace('/[^\d.]/s', '',$arr['2']);
		$data1['credit_all_fail']=preg_replace('/[^\d.]/s', '',$arr['3']);


		$pjxfjd=$html->find('#pjxfjd',0);
		$data1['gpa']=preg_replace('/[^\d.]/s', '',$pjxfjd->innertext());

		$xfjdzh=$html->find('#xfjdzh',0);
		$data1['total_points']=preg_replace('/[^\d.]/s', '',$xfjdzh->innertext());


		$tr=$html->find('#Datagrid2 tbody tr');
		array_shift($tr);
		$j=0;
		foreach ($tr as $value1) {
			$data2[$j]['student_id']=$this->user;
			$data2[$j]['course_type']= $value1->find('td',0)->innertext();
			$data2[$j]['credit_req']= preg_replace('/[^\d.]/s', '',$value1->find('td',1)->innertext());
			$data2[$j]['credit_get']= preg_replace('/[^\d.]/s', '',$value1->find('td',2)->innertext());
			$data2[$j]['credit_fail']= preg_replace('/[^\d.]/s', '',$value1->find('td',3)->innertext());
			$data2[$j]['credit_need']= preg_replace('/[^\d.]/s', '',$value1->find('td',4)->innertext());

			$j++;
		}

		$data['res1']=$data1;
		$data['res2']=$data2;

		return $data;
	}


	/**
	 * 加载目标网站图片验证码
	 * string $authcode_url 目标网站验证码地址
	 */
	function showAuthcode()
	{
	    $ch = curl_init($this->authcode_url);
	    curl_setopt($ch,CURLOPT_COOKIEJAR, $this->cookieFile); // 把返回来的cookie信息保存在文件中
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    $content = curl_exec($ch);
	    var_dump($this->cookieFile);
	    curl_close($ch);
	}

	/**
	 * 学生个人信息查询
	 * @return [type] [description]
	 */
	function getPersonalInfo(){
		$curl2=curl_init();
	    curl_setopt ($curl2,CURLOPT_REFERER,self::XSMAIN.'xh='.$this->user);//.'#a'
	    curl_setopt($curl2, CURLOPT_COOKIEFILE, $this->cookieFile); 
	    curl_setopt($curl2, CURLOPT_HEADER, false); 
	    curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true); 
	    curl_setopt($curl2, CURLOPT_TIMEOUT, 20); 
	    curl_setopt($curl2, CURLOPT_AUTOREFERER, true); 
	    curl_setopt($curl2, CURLOPT_FOLLOWLOCATION, true); 

	    curl_setopt($curl2, CURLOPT_URL, self::XSGRXX.'xh='.$this->user.'&xm='.$this->xm.'&gnmkdm=N121601');
	    //登陆后要从哪个页面获取信息

	    //http://61.139.105.138/xsgrxx.aspx?xh=14101070205&xm=%BD%AD%D1%EE&gnmkdm=N121501

	    $content=mb_convert_encoding( curl_exec($curl2),'utf-8', array('Unicode','ASCII','GB2312','GBK','UTF-8'));

	    // curl_close($curl2);

		$hdp = new htmlDomParser();	
		$html=$hdp->str_get_html($content);//创建DOM

		// $e=$html->find('.formbox .formlist',0);
		// $i=0;
		// foreach ($e->find('tr') as $value1) {
		// 	$arr[$i]=$value1->innertext();
		// 	$i++;
		// }

		$arr['xh']=$html->find('#xh',0)->innertext();
		$arr['xm']=$html->find('#xm',0)->innertext();
		$arr['lbl_mz']=$html->find('#lbl_mz',0)->innertext();
		$arr['lbl_xb']=$html->find('#lbl_xb',0)->innertext();
		$arr['lbl_zzmm']=$html->find('#lbl_zzmm',0)->innertext();
		$arr['lbl_lydq']=$html->find('#lbl_lydq',0)->innertext();
		$arr['lbl_lys']=$html->find('#lbl_lys',0)->innertext();
		$arr['lbl_byzx']=$html->find('#lbl_byzx',0)->innertext();
		$arr['lbl_xy']=$html->find('#lbl_xy',0)->innertext();
		$arr['lbl_zymc']=$html->find('#lbl_zymc',0)->innertext();
		$arr['lbl_xzb']=$html->find('#lbl_xzb',0)->innertext();
		$arr['lbl_xz']=$html->find('#lbl_xz',0)->innertext();
		$arr['lbl_xjzt']=$html->find('#lbl_xjzt',0)->innertext();
		$arr['lbl_dqszj']=$html->find('#lbl_dqszj',0)->innertext();
		$arr['lbl_sfzh']=$html->find('#lbl_sfzh',0)->innertext();
		$arr['lbl_ksh']=$html->find('#lbl_ksh',0)->innertext();
		$arr['lbl_lxdh']=$html->find('#lbl_lxdh',0)->innertext();
		$arr['lbl_ssh']=$html->find('#lbl_ssh',0)->innertext();
		$arr['lbl_byzx']=$html->find('#lbl_byzx',0)->innertext();
		$arr['lbl_xszh']=$html->find('#lbl_xszh',0)->innertext();
		$arr['lbl_RDSJ']=$html->find('#lbl_RDSJ',0)->innertext();
		$arr['lbl_zkzh']=$html->find('#lbl_zkzh',0)->innertext();
		$arr['lbl_csrq']=$html->find('#lbl_csrq',0)->innertext();
		$arr['lbl_CC']=$html->find('#lbl_CC',0)->innertext();
		$arr['lbl_dqszj']=$html->find('#lbl_dqszj',0)->innertext();
		$arr['lbl_jtszd']=$html->find('#lbl_jtszd',0)->innertext();





		return $arr;

	}

	/**
	 * 学生等级考试查询
	 * @return [type] [description]
	 */
	function getExaminationInfo(){
		$curl2=curl_init();
	    curl_setopt ($curl2,CURLOPT_REFERER,self::XSMAIN.'xh='.$this->user);//.'#a'
	    curl_setopt($curl2, CURLOPT_COOKIEFILE, $this->cookieFile); 
	    curl_setopt($curl2, CURLOPT_HEADER, false); 
	    curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true); 
	    curl_setopt($curl2, CURLOPT_TIMEOUT, 20); 
	    curl_setopt($curl2, CURLOPT_AUTOREFERER, true); 
	    curl_setopt($curl2, CURLOPT_FOLLOWLOCATION, true); 

	    curl_setopt($curl2, CURLOPT_URL, self::XSDJKSCX.'xh='.$this->user.'&xm='.$this->xm.'&gnmkdm=N121606');
	    //登陆后要从哪个页面获取信息

	    //http://61.139.105.138/xsdjkscx.aspx?xh=14101070203&xm=%BA%D8%D3%EE%C1%FA&gnmkdm=N121606

	    $content=mb_convert_encoding( curl_exec($curl2),'utf-8', array('Unicode','ASCII','GB2312','GBK','UTF-8'));

	    // curl_close($curl2);

		$hdp = new htmlDomParser();	
		$html=$hdp->str_get_html($content);//创建DOM

		$e=$html->find('#DataGrid1 tr',1);

		$arr['xn']=$e->find('td',0)->innertext();
		$arr['xq']=$e->find('td',1)->innertext();
		$arr['name']=$e->find('td',2)->innertext();
		$arr['zkzh']=$e->find('td',3)->innertext();
		$arr['ksrq']=$e->find('td',4)->innertext();
		$arr['cj']=$e->find('td',5)->innertext();
		$arr['tlcj']=$e->find('td',6)->innertext();
		$arr['ydcj']=$e->find('td',7)->innertext();
		$arr['xzcj']=$e->find('td',8)->innertext();
		$arr['zhcj']=$e->find('td',9)->innertext();
		
		return $arr;
	
	}

	/**
	 * 获取学生地址(一次性函数，已经使用完)
	 * @param  [type] $idnum [description]
	 * @return [type]        [description]
	 */
	function getAddress($idnum){
		// $idnum='17510699121390';
		$curl2=curl_init();
	    curl_setopt ($curl2,CURLOPT_REFERER,'http://lqcx.suse.edu.cn/login.asp');
	    // curl_setopt($curl2, CURLOPT_COOKIEFILE, $this->cookieFile); 
	    curl_setopt($curl2, CURLOPT_HEADER, false); 
	    curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true); 
	    curl_setopt($curl2, CURLOPT_TIMEOUT, 20); 
	    curl_setopt($curl2, CURLOPT_AUTOREFERER, true); 
	    curl_setopt($curl2, CURLOPT_FOLLOWLOCATION, true); 
	    curl_setopt($curl2,CURLOPT_POSTFIELDS, 'idnum='.$idnum.'&bt1=%CC%E1++%BD%BB'); //提交查询信息
	    curl_setopt($curl2, CURLOPT_URL, 'http://lqcx.suse.edu.cn/showinfo.asp');
	    //http://lqcx.suse.edu.cn/login.asp

	    $content=mb_convert_encoding( curl_exec($curl2),'utf-8', array('Unicode','ASCII','GB2312','GBK','UTF-8'));

	    // curl_close($curl2);

		$hdp = new htmlDomParser();	
		$html=$hdp->str_get_html($content);//创建DOM

		$e=$html->find('td[align=center]',1);
		$arr1=explode('：',$e->innertext());
		$arr=explode(' ',$arr1['1']);
		$arr=explode('<',$arr['8']);

		$data['number']=$idnum;
		$data['address']=$arr[0];
		return $data;
	}


}