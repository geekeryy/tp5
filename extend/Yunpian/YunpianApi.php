<?php
namespace Yunpian;

class YunpianApi{
	private $ch;
	private $apikey;
	private $mobile;
	// private $text;
	function __construct(){
		//apikey
		$this->apikey= config('yunpian_apikey'); 	
		
		// $this->text="你好啊";
		$this->ch = curl_init();

		/* 设置验证方式 */

		curl_setopt($this->ch, CURLOPT_HTTPHEADER, array('Accept:text/plain;charset=utf-8', 'Content-Type:application/x-www-form-urlencoded','charset=utf-8'));

		/* 设置返回结果为流 */
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);

		/* 设置超时时间*/
		curl_setopt($this->ch, CURLOPT_TIMEOUT, 10);

		/* 设置通信方式 */
		curl_setopt($this->ch, CURLOPT_POST, 1);
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
	}




	function get_user($ch,$apikey){
	    curl_setopt ($this->ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/user/get.json');
	    curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query(array('apikey' => $this->apikey)));
	    return curl_exec($this->ch);
	}
	function send($ch,$data){
	    curl_setopt ($this->ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/single_send.json');
	    curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($data));
	    return curl_exec($this->ch);
	}
	function tpl_send($ch,$data){
	    curl_setopt ($this->ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/tpl_single_send.json');
	    curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($data));
	    return curl_exec($this->ch);
	}
	function voice_send($ch,$data){
	    curl_setopt ($this->ch, CURLOPT_URL, 'http://voice.yunpian.com/v2/voice/send.json');
	    curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($data));
	    return curl_exec($this->ch);
	}

	/*发送短信验证码*/
	function send_tpl($mobile,$tpl,$content=''){
		//构造6位短信验证码
		$code=rand(100000,999999);
		//参数中获取用户手机号
		$this->mobile = $mobile; 

		//构造短信模板数据
		//$data=array('tpl_id'=>'1898268','tpl_value'=>('#time#').'='.urlencode($code).'&'.urlencode('#content#').'='.urlencode(time()),'apikey'=>$this->apikey,'mobile'=>$this->mobile);
		switch ($tpl) {
			case 'code':
				$data=array('tpl_id'=>'1899346','tpl_value'=>('#code#').'='.urlencode($code),'apikey'=>$this->apikey,'mobile'=>$this->mobile);
				break;
			case 'code1':
				$time=date('Y-m-d h:i:s',time());
				$data=array('tpl_id'=>'1898268','tpl_value'=>('#time#').'='.urlencode($time).'&'.urlencode('#content#').'='.urlencode("，您的验证码是：".$code),'apikey'=>$this->apikey,'mobile'=>$this->mobile);
				break;
					
			default:
				break;
		}
		//执行短信发送
		$json_data = $this->tpl_send($this->ch,$data);
		$array = json_decode($json_data,true);
		//存储code验证码和创建时间
		$yunpian=array(
			'phone'=>$mobile,
			'code'=>$code,
			'time'=>time(),
			);
		$array['yunpian']=$yunpian;
		//返回状态信息
		return $array;
	}

	/*发送语音验证码*/
	function send_voice($mobile){
		//构造4位短信验证码
		$code=rand(1000,9999);
		//参数中获取用户手机号
		$this->mobile = $mobile; 
		//构造短信模板数据
		$data=array('code'=>$code,'apikey'=>$this->apikey,'mobile'=>$this->mobile);
		//发送语言验证码
		$json_data =voice_send($this->ch,$data);

		$array = json_decode($json_data,true);
		//存储code验证码和创建时间
		$yunpian=array(
			'code'=>$code,
			'time'=>time(),
			);
		$array['yunpian']=$yunpian;
		//返回状态信息
		return $array;
	}
}
