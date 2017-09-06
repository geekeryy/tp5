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
	private $viewstate;
	private $param;
	function __construct($user='',$password='',$code=''){
		if (!$user) {
			$this->user=session('user');
		}
		$this->user=$user;
		$this->password=$password;
		$this->code=$code;
		if (session('name')) {
			$this->xm=session('name');
		}
		$this->cookieFile=APP_PATH.'../runtime/cookie'.session_id().'.tmp';
	}

	/**
	 * 获取登陆所需的viewstate
	 * @return [type] [description]
	 */
	function getViewstate(){
		$ch = curl_init($this->url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//0获取后直接打印出来
	    $content =curl_exec($ch);
	    curl_close($ch);
	    $hdp = new htmlDomParser();	
		$html=$hdp->str_get_html($content);//创建DOM
		$e=$html->find('input',0);
		$this->viewstate=$e->value;
	}
	/**
	 * 执行模拟登陆，保存名字信息
	 * @return [type] [description]
	 */
	function curlLogin()
	{    

		//获取隐藏字段
		$this->getViewstate();
		// $loginParams为curl模拟登录时post的参数
		$this->loginParams['__VIEWSTATE'] = $this->viewstate;
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
	    session('name',$name);
	    return $name;
	}
	/**
	 * 学生课表查询，获取课表页面
	 * @return [type] [description]
	 */
	function getCourseInfo(){
		$curl2=curl_init();
	    curl_setopt ($curl2,CURLOPT_REFERER,'http://61.139.105.138/xs_main.aspx?xh='.$this->user);//.'#a'
	    curl_setopt($curl2, CURLOPT_COOKIEFILE, $this->cookieFile); 
	    curl_setopt($curl2, CURLOPT_HEADER, false); 
	    curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true); 
	    curl_setopt($curl2, CURLOPT_TIMEOUT, 20); 
	    curl_setopt($curl2, CURLOPT_AUTOREFERER, true); 
	    curl_setopt($curl2, CURLOPT_FOLLOWLOCATION, true); 

	    curl_setopt($curl2, CURLOPT_URL, 'http://61.139.105.138/xskbcx.aspx?xh='.$this->user.'&xm='.$this->xm.'&gnmkdm=N121603');
	     //登陆后要从哪个页面获取信息

	     //http://61.139.105.138/xskbcx.aspx?xh=14101070205&xm=%BD%AD%D1%EE&gnmkdm=N121603

	     $en_contents=mb_convert_encoding( curl_exec($curl2),'utf-8', array('Unicode','ASCII','GB2312','GBK','UTF-8'));

	     curl_close($curl2);

	     return $en_contents;
	}

	/**
	 * 获取xs_main.aspx的Viewstate，废弃
	 * @return [type] [description]
	 */
	function getViewstate2(){
		$curl2=curl_init();
	    curl_setopt ($curl2,CURLOPT_REFERER,'http://61.139.105.138/xs_main.aspx?xh='.$this->user);//.'#a'
	    curl_setopt($curl2, CURLOPT_COOKIEFILE, $this->cookieFile); 
	    curl_setopt($curl2, CURLOPT_HEADER, false); 
	    curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true); 
	    curl_setopt($curl2, CURLOPT_TIMEOUT, 20); 
	    curl_setopt($curl2, CURLOPT_AUTOREFERER, true); 
	    curl_setopt($curl2, CURLOPT_FOLLOWLOCATION, true); 
	    curl_setopt($curl2, CURLOPT_URL, 'http://61.139.105.138/content.aspx');
	    $content =curl_exec($curl2);
	    curl_close($curl2);
	    $hdp = new htmlDomParser();	
		$html=$hdp->str_get_html($content);//创建DOM
		// $e=$html->find('input[name=__VIEWSTATE]',2);
		$e=$html->find('input[type=hidden]',0);

		return $e->value;
		// $this->viewstate=$e->value;
	}

	/**
	 * 构造获取成绩信息所需的参数
	 * @return [type] [description]
	 */
	function getAchViewstate($ddlxn){
		// http://61.139.105.138/xscjcx_dq.aspx?xh=14101070205&xm=%BD%AD%D1%EE&gnmkdm=N121605
		$curl2=curl_init();
	    curl_setopt ($curl2,CURLOPT_REFERER,'http://61.139.105.138/xs_main.aspx?xh='.$this->user);//.'#a'
	    curl_setopt($curl2, CURLOPT_COOKIEFILE, $this->cookieFile); 
	    curl_setopt($curl2, CURLOPT_HEADER, false); 
	    curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true); 
	    curl_setopt($curl2, CURLOPT_TIMEOUT, 20); 
	    curl_setopt($curl2, CURLOPT_AUTOREFERER, true); 
	    curl_setopt($curl2, CURLOPT_FOLLOWLOCATION, true); 
	    curl_setopt($curl2, CURLOPT_URL, 'http://61.139.105.138/xscjcx_dq.aspx?xh='.$this->user.'&xm='.$this->xm.'&gnmkdm=N121605');
	     //登陆后要从哪个页面获取信息
		$content=curl_exec($curl2);
	    curl_close($curl2);

	    $hdp = new htmlDomParser();	
		$html=$hdp->str_get_html($content);//创建DOM
		$e=$html->find('#Form1 input[type=hidden]',2);

		$this->param['__EVENTTARGET']='';
		$this->param['__EVENTARGUMENT']='';
		$this->param['__VIEWSTATE']=$e->value;
		$this->param['btnCx']='查询';
		// $this->param['ddlxn']=$xn->value;
		// $this->param['ddlxq']=$xq->value;
		$this->param['ddlxn']=$ddlxn;
		$this->param['ddlxq']='全部';

	    return $this->param;
	}

	/**
	 * 获取学生成绩
	 * 返回成绩数组
	 * @return [type] [description]
	 */
	function getAchievement($ddlxn){
		// http://61.139.105.138/xscjcx_dq.aspx?xh=14101070205&xm=%BD%AD%D1%EE&gnmkdm=N121605
		$curl2=curl_init();
	    curl_setopt ($curl2,CURLOPT_REFERER,'http://61.139.105.138/xs_main.aspx?xh='.$this->user);//.'#a'
	    curl_setopt($curl2, CURLOPT_COOKIEFILE, $this->cookieFile); 
	    curl_setopt($curl2, CURLOPT_HEADER, false); 
	    curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true); 
	    curl_setopt($curl2, CURLOPT_TIMEOUT, 20); 
	    curl_setopt($curl2, CURLOPT_AUTOREFERER, true); 
	    curl_setopt($curl2, CURLOPT_FOLLOWLOCATION, true); 
	    curl_setopt($curl2,CURLOPT_POSTFIELDS, $this->getAchViewstate($ddlxn)); //提交查询信息
	    curl_setopt($curl2, CURLOPT_URL, 'http://61.139.105.138/xscjcx_dq.aspx?xh='.$this->user.'&xm='.$this->xm.'&gnmkdm=N121605');
	     //登陆后要从哪个页面获取信息

	     $content=mb_convert_encoding( curl_exec($curl2),'utf-8', array('Unicode','ASCII','GB2312','GBK','UTF-8'));
		// $content=curl_exec($curl2);
	     curl_close($curl2);

	    $hdp = new htmlDomParser();	
		$html=$hdp->str_get_html($content);//创建DOM
		$e=$html->find('#DataGrid1 tr');
		$arr=array();
		array_shift($e);
		$i=0;
		foreach ($e as $value1) {
			$arr[$i]['student_id']=$this->user;
			$arr[$i]['year'] = $value1->find('td',0)->innertext();
			$arr[$i]['semester'] = $value1->find('td',1)->innertext();
			$arr[$i]['course_id'] = $value1->find('td',2)->innertext();
			$arr[$i]['course_name'] = $value1->find('td',3)->innertext();
			$arr[$i]['course_type'] = $value1->find('td',4)->innertext();
			$arr[$i]['course_ascription'] = $value1->find('td',5)->innertext();
			$arr[$i]['credit'] = $value1->find('td',6)->innertext();
			$arr[$i]['peacetime_ach'] = $value1->find('td',7)->innertext();
			$arr[$i]['midterm_ach'] = $value1->find('td',8)->innertext();
			$arr[$i]['final_ach'] = $value1->find('td',9)->innertext();
			$arr[$i]['experiment_ach'] = $value1->find('td',10)->innertext();
			$arr[$i]['achievement'] = $value1->find('td',11)->innertext();
			$arr[$i]['makeup_ach'] = $value1->find('td',12)->innertext();
			$arr[$i]['repair'] = $value1->find('td',13)->innertext();
			$arr[$i]['college'] = $value1->find('td',14)->innertext();
			$arr[$i]['remarks'] = $value1->find('td',15)->innertext();
			$arr[$i]['makeup_remarks'] = $value1->find('td',16)->innertext();
			$i++;
		}

	     return $arr;
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

	    $content =curl_exec($ch);
	    var_dump($this->cookieFile);
	    curl_close($ch);
	}

	/**
	 * 返回所有课程信息以及其它信息
	 * @param  [type] $html [description]
	 * @return [type]       [description]
	 */
	function getAllCourse($content){

		$hdp = new htmlDomParser();
		$html=$hdp->str_get_html($content);//创建DOM


		$data=array();
		$i=0;
		$arr=array();
		$item=$html->find('#Table1 tr');
		foreach ($item as $value1) {
			foreach ($value1->find('td') as $value2) {
				if (strstr($value2->innertext(),'<br>')) {
					$arr[$i]=explode('<br>',$value2->innertext());
					$i++;
				}
			}
		}

		$data['res1']=$arr;


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

		$data['res2']=$info;

		return $data;
	}


}