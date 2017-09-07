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
	//成绩数组
	private $ach_info;

	//成绩查询2
	const XSCJCX='http://61.139.105.138/xscjcx.aspx?';
	//成绩查询1
	const XSCJCX_DQ='http://61.139.105.138/xscjcx_dq.aspx?';

	const XSMAIN='http://61.139.105.138/xs_main.aspx?';
	const XSKBCX='http://61.139.105.138/xskbcx.aspx?';


	function __construct($user='',$password='',$code=''){
		// if (!$user) {
		// 	$this->user=session('user');
		// }
		$this->user=$user;
		$this->password=$password;
		$this->code=$code;
		// if (session('name')) {
		// 	$this->xm=session('name');
		// }
		$this->cookieFile=APP_PATH.'../runtime/cookie'.session_id().'.tmp';
	}

	/**
	 * 
	 * @return [type] [description]
	 */
	function getViewstate(){

	}
	/**
	 * 执行模拟登陆，保存名字信息
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
	    // xhxm
	    $hdp = new htmlDomParser();	
		$html=$hdp->str_get_html($content);//创建DOM
		$e=$html->find('#xhxm',0);
		$name=substr($e->innertext(), 0,-4);
		$this->xm=$name;
	    // session('name',$name);
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
		array_shift($e);
		$i=0;
		foreach ($e as $value1) {
			$this->ach_info[$i]['student_id']=$this->user;
			$this->ach_info[$i]['year'] = $value1->find('td',0)->innertext();
			$this->ach_info[$i]['semester'] = $value1->find('td',1)->innertext();
			$this->ach_info[$i]['course_id'] = $value1->find('td',2)->innertext();
			$this->ach_info[$i]['course_name'] = $value1->find('td',3)->innertext();
			$this->ach_info[$i]['course_type'] = $value1->find('td',4)->innertext();
			$this->ach_info[$i]['course_ascription'] = $value1->find('td',5)->innertext();
			$this->ach_info[$i]['credit'] = $value1->find('td',6)->innertext();
			$this->ach_info[$i]['peacetime_ach'] = $value1->find('td',7)->innertext();
			$this->ach_info[$i]['midterm_ach'] = $value1->find('td',8)->innertext();
			$this->ach_info[$i]['final_ach'] = $value1->find('td',9)->innertext();
			$this->ach_info[$i]['experiment_ach'] = $value1->find('td',10)->innertext();
			$this->ach_info[$i]['achievement'] = $value1->find('td',11)->innertext();
			$this->ach_info[$i]['makeup_ach'] = $value1->find('td',12)->innertext();
			$this->ach_info[$i]['repair_remarks'] = $value1->find('td',13)->innertext();
			$this->ach_info[$i]['college'] = $value1->find('td',14)->innertext();
			$this->ach_info[$i]['remarks'] = $value1->find('td',15)->innertext();
			$this->ach_info[$i]['makeup_remarks'] = $value1->find('td',16)->innertext();
			$i++;
		}
		return $arr;
	}

	/**
	 * 成绩查询2
	 * 返回成绩数组
	 * @return [type] [description]
	 */
	function getAchievement2(){

	//构造成绩查询2所需参数
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
		//删除数组第一个元素
		array_shift($e);
		$i=0;
		foreach ($e as $value1) {
			// $this->ach_info[$i]['student_id']=$this->user;
			// $this->ach_info[$i]['year'] = $value1->find('td',0)->innertext();
			// $this->ach_info[$i]['semester'] = $value1->find('td',1)->innertext();
			// $this->ach_info[$i]['course_id'] = $value1->find('td',2)->innertext();
			// $this->ach_info[$i]['course_name'] = $value1->find('td',3)->innertext();
			// $this->ach_info[$i]['course_type'] = $value1->find('td',4)->innertext();
			// $this->ach_info[$i]['course_ascription'] = $value1->find('td',5)->innertext();
			// $this->ach_info[$i]['credit'] = $value1->find('td',6)->innertext();
			$this->ach_info[$i]['point'] = $value1->find('td',7)->innertext();
			// $this->ach_info[$i]['achievement'] = $value1->find('td',8)->innertext();
			$this->ach_info[$i]['minor_remarks'] = $value1->find('td',9)->innertext();
			// $this->ach_info[$i]['makeup_ach'] = $value1->find('td',10)->innertext();
			$this->ach_info[$i]['repair_ach'] = $value1->find('td',11)->innertext();
			// $this->ach_info[$i]['college'] = $value1->find('td',12)->innertext();
			// $this->ach_info[$i]['remarks'] = $value1->find('td',13)->innertext();
			// $this->ach_info[$i]['repair_remarks'] = $value1->find('td',14)->innertext();
			$i++;
		}

	     return $arr;
	}

	/**
	 * 成绩查询
	 * @return [type] [description]
	 */
	function getAchievement(){
		$this->getAchievement1();
		$this->getAchievement2();
		return $this->ach_info;
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





}