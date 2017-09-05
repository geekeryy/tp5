<?php
namespace Reptile;
class Suse{
	private $url='http://61.139.105.138/default2.aspx';
	private $xm='江杨';
	private $authcode_url='http://61.139.105.138/CheckCode.aspx';
	private $cookieFile;
	private $user;
	private $password;
	private $code;
	private $viewstate;
	function __construct($user,$password){
		$this->user=$user;
		$this->password=$password;
		$this->cookieFile=APP_PATH.'../runtime/cookie.tmp';
	}
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
	function curlLogin()
	{    
		$code = trim(input('param.code')); 

		// $loginParams为curl模拟登录时post的参数
		$this->loginParams['__VIEWSTATE'] = $this->viewstate;
		$this->loginParams['RadioButtonList1'] = '学生';
		$this->loginParams['TextBox2'] = $this->password;
		$this->loginParams['txtUserName'] = $this->user;
		$this->loginParams['Button1'] = '';
		$this->loginParams['lbLanguage'] = '';
		$this->loginParams['hidPdrs'] = '';
		$this->loginParams['hidsc'] = '';
		$this->loginParams['txtSecretCode'] = $code; 
	    $ch = curl_init($this->url);
	    curl_setopt($ch,CURLOPT_COOKIEFILE, $this->cookieFile); //同时发送Cookie
	    curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);//设定返回的数据是否自动显示
	    curl_setopt($ch, CURLOPT_HEADER, 0);//设定是否显示头信 息
	    curl_setopt($ch, CURLOPT_NOBODY, false);//设定是否输出页面 内容
	    curl_setopt($ch,CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	    curl_setopt($ch,CURLOPT_POSTFIELDS, $this->loginParams); //提交查询信息
	    curl_exec($ch);//返回结果
	    curl_close($ch); //关闭

	}

	function getContent(){
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
	     // $res=curl_exec($curl2); 
	     curl_close($curl2);
	     // echo $res;
	     // header('Location:http://61.139.105.138/xs_main.aspx?xh='.$user);
	     // header("Content-Type:text/html;charset=gb2312");
	     return $en_contents;
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

	function getAllCourse($html){
		$i=0;
		$info=array();
		$item=$html->find('#Table1 tr');
		foreach ($item as $value1) {
			foreach ($value1->find('td') as $value2) {
				if (strstr($value2->innertext(),'<br>')) {
					$info[$i]=explode('<br>',$value2->innertext());
					$i++;
				}
			}
		}
		// var_dump($info);exit();
		return $info;
	}

	function getSomeInfo($html){
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
// var_dump($info);exit();
			return $info;
	}

}