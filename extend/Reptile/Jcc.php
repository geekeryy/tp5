<?php
namespace Reptile;

class Jcc{
	private $loginParams;
	private $url='http://61.139.105.105:8088/Account/LogOn?ReturnUrl=%2f';
	private $authcode_url='http://61.139.105.105:8088/Account/GetValidateCode';
	private $cookieFile;
	private $username;
	private $password;
	private $code;
	function __construct($username='',$password='',$code=''){
		$this->username=$username;
		$this->password=$password;
		$this->code=$code;
		$this->cookieFile=APP_PATH.'../runtime/cookie2'.session_id().'.tmp';
	}
	/**
	 * 执行模拟登陆计财处
	 * @return [type] [description]
	 */
	function jccLogin(){ 

	// 获取登陆所需的viewstate
		// $ch1 = curl_init($this->url);
		// curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);//0获取后直接打印出来
	 //    $content =curl_exec($ch1);
	 //    curl_close($ch1);
	 //    $hdp = new htmlDomParser();	
		// $html=$hdp->str_get_html($content);//创建DOM
		// $e=$html->find('input',0);
		// $viewstate=$e->value;
		// unset($hdp);


		$this->loginParams['Password'] = $this->password;
		$this->loginParams['UserName'] = $this->username;
		$this->loginParams['ValidateCode'] = $this->code;


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
	 //    $hdp = new htmlDomParser();	
		// $html=$hdp->str_get_html($content);//创建DOM
		// $e=$html->find('#xhxm',0);
		// $name=substr($e->innertext(), 0,-4);
		// $this->xm=$name;
	    return $content;
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
	 * 学生课表查询，获取课表页面
	 * @return [type] [description]
	 */
	function getjccInfo(){
		// http://61.139.105.105:8088/Report/YskReport
		// $curl2=curl_init();
	 //    curl_setopt ($curl2,CURLOPT_REFERER,'http://61.139.105.105:8088/');//.'#a'
	 //    curl_setopt($curl2, CURLOPT_COOKIEFILE, $this->cookieFile); 
	 //    curl_setopt($curl2, CURLOPT_HEADER, false); 
	 //    curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true); 
	 //    curl_setopt($curl2, CURLOPT_TIMEOUT, 20); 
	 //    curl_setopt($curl2, CURLOPT_AUTOREFERER, true); 
	 //    curl_setopt($curl2, CURLOPT_FOLLOWLOCATION, true); 

	    // curl_setopt($curl2, CURLOPT_URL, 'http://61.139.105.105:8088/Report/YskReport');
	    // curl_setopt($curl2, CURLOPT_URL, 'http://61.139.105.105:8088/Student/Detail');
	    //登陆后要从哪个页面获取信息

	    //http://61.139.105.138/xskbcx.aspx?xh=14101070205&xm=%BD%AD%D1%EE&gnmkdm=N121603


	    $ch = curl_init('http://61.139.105.105:8088/Report/YskReport');
	    // $ch = curl_init('http://61.139.105.105:8088/Report/DetailReport');
	    // $ch = curl_init('http://61.139.105.105:8088/Student/Detail');
	    // $ch = curl_init('http://61.139.105.105:8088/Report/SumReport');
	    
	    // $ch = curl_init('http://www.baidu.com');
	    curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieFile);
	    curl_setopt($ch, CURLOPT_HEADER, false); 
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	    curl_setopt($ch, CURLOPT_TIMEOUT, 20); 
	    // $content = curl_exec($ch);
	    // var_dump($this->cookieFile);
	    $contents=curl_exec($ch);

	    // $contents=mb_convert_encoding( curl_exec($ch),'utf-8', array('Unicode','ASCII','GB2312','GBK','UTF-8'));

	    curl_close($ch);

		return $contents;

	}

	
}