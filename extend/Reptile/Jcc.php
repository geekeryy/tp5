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

	    $hdp = new htmlDomParser();	
		$html=$hdp->str_get_html($content);//创建DOM

		$e=$html->find('#navigator_bar table tr td text',0);
		$arr=explode('strong>', $e->innertext());
		$info=substr($arr['1'], 0,-2);
		$arr1=explode('【',$info);
		$arr1['1']=substr($arr1['1'], 0,-4);

		$this->name=$arr1[0];
		$this->student_id=$arr1[1];

	    return $arr1;
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
	function getJccInfo(){

	    $ch = curl_init('http://61.139.105.105:8088/Report/YskReport');
	    // $ch = curl_init('http://61.139.105.105:8088/Report/DetailReport');
	    // $ch = curl_init('http://61.139.105.105:8088/Student/Detail');
	    // $ch = curl_init('http://61.139.105.105:8088/Report/SumReport');
	    
	    curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieFile);
	    curl_setopt($ch, CURLOPT_HEADER, false); 
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	    curl_setopt($ch, CURLOPT_TIMEOUT, 20); 

	    $content=curl_exec($ch);

	    // $content=mb_convert_encoding( curl_exec($ch),'utf-8', array('Unicode','ASCII','GB2312','GBK','UTF-8'));

	    curl_close($ch);
// echo $content;
		$hdp = new htmlDomParser();	
		$html=$hdp->str_get_html($content);//创建DOM
		$e=$html->find('#slt',0);
		$tr=$html->find('tr');

		array_shift($tr);
		$i=0;
		foreach ( $tr as $value1) {
			$arr[$i]['student_id']=$this->student_id;
			if (!str_replace(' ','',$value1->find('td',0)->innertext())) {
				$arr[$i]['sfqj']=$arr[($i-1)]['sfqj'];
			}else{
				$arr[$i]['sfqj']=str_replace(' ','',$value1->find('td',0)->innertext());
			}
			$arr[$i]['sfxmbm']=str_replace(' ','',$value1->find('td',1)->innertext());
			$arr[$i]['sfxmmc']=str_replace(' ','',$value1->find('td',2)->innertext());
			$arr[$i]['ygjfje']=str_replace(' ','',$value1->find('td',3)->innertext());
			$arr[$i]['yjjfje']=str_replace(' ','',$value1->find('td',4)->innertext());
			$arr[$i]['jmje']=str_replace(' ','',$value1->find('td',5)->innertext());
			$arr[$i]['tfje']=str_replace(' ','',$value1->find('td',6)->innertext());
			$arr[$i]['qfje']=str_replace(' ','',$value1->find('td',7)->innertext());
			$i++;
		}
		array_pop($arr);
		return $arr;

	}


	/**
	 * 学生信息维护
	 * @return [type] [description]
	 */
	function getStudentDetail(){

	    // $ch = curl_init('http://61.139.105.105:8088/Report/YskReport');
	    // $ch = curl_init('http://61.139.105.105:8088/Report/DetailReport');
	    $ch = curl_init('http://61.139.105.105:8088/Student/Detail');
	    // $ch = curl_init('http://61.139.105.105:8088/Report/SumReport');
	    
	    curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieFile);
	    curl_setopt($ch, CURLOPT_HEADER, false); 
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	    curl_setopt($ch, CURLOPT_TIMEOUT, 20); 

	    $content=curl_exec($ch);

	    // echo $content;
		$hdp = new htmlDomParser();	
		$html=$hdp->str_get_html($content);//创建DOM
		$e=$html->find('#slt',0);
		$td=$html->find('tr td');

		$i=0;
		foreach ( $td as $value1) {
			$arr[$i]=$value1->innertext();
			$i++;
		}

		$info['xh']=$this->student_id;
		$info['xm']=$this->name;
		$info['lbl_xb']=$arr[3];
		$info['lbl_mz']=$arr[5];
		$info['lbl_dqszj']=$arr[7];
		$info['lbl_sfzh']=$arr[11];
		$info['lbl_lydq']=$arr[19];
		$info['lbl_khyh']=$arr[21];
		$info['lbl_yhkh']=$arr[23];
		$info['lbl_lxdh']=$arr[25];


		return $info;
	}

	
}