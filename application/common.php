<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件




function curlLogin($url, $cookieFile, $loginParams)
{   
    $user = '14101070205';//用户名
    $password = 'a1126254578';//密码
    $ch = curl_init($url);
    curl_setopt($ch,CURLOPT_COOKIEFILE, $cookieFile); //同时发送Cookie
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);//设定返回的数据是否自动显示
    curl_setopt($ch, CURLOPT_HEADER, 0);//设定是否显示头信 息
    curl_setopt($ch, CURLOPT_NOBODY, false);//设定是否输出页面 内容
    curl_setopt($ch,CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $loginParams); //提交查询信息
    curl_exec($ch);//返回结果
    curl_close($ch); //关闭

    $curl2=curl_init();

    $xm='江杨';
    curl_setopt ($curl2,CURLOPT_REFERER,'http://61.139.105.138/xs_main.aspx?xh='.$user);//.'#a'
    curl_setopt($curl2, CURLOPT_COOKIEFILE, $cookieFile); 
     curl_setopt($curl2, CURLOPT_HEADER, false); 
     curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true); 
     curl_setopt($curl2, CURLOPT_TIMEOUT, 20); 
     curl_setopt($curl2, CURLOPT_AUTOREFERER, true); 
     curl_setopt($curl2, CURLOPT_FOLLOWLOCATION, true); 
     curl_setopt($curl2, CURLOPT_URL, 'http://61.139.105.138/xskbcx.aspx?xh='.$user.'&xm='.$xm.'&gnmkdm=N121603');
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
function showAuthcode( $authcode_url )
{
    $cookieFile = SCRIPT_ROOT.'cookie.tmp';
    $ch = curl_init($authcode_url);
    curl_setopt($ch,CURLOPT_COOKIEJAR, $cookieFile); // 把返回来的cookie信息保存在文件中
    curl_setopt($ch, CURLOPT_HEADER, 0);

    $content =curl_exec($ch);
    var_dump($cookieFile);
    curl_close($ch);
}



/**
 * 输出调试信息
 * @author KK
 * @param mixed $data 要输出的调试数据
 * @param int $mode 调试模式
 * 解释：11=输出调试数据并停止运行，111=附加运行回溯输出并停止运行
 * 110=附加运行回溯输出但不停止运行
 * 
 * @example
 * 
 * ```php
 * debug(123, 110);
 * debug([1,2,3], 111);
 * debug([1, 2, 3, 'a' => 'b'], 11);	
 * ```
 */
function debug($data, $mode = 0){
	    static $debugCount = 0;
	    $debugCount++;
	        
	    $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest' || isset($_GET['_isAjax']) || isset($_POST['_isAjax']);
	        
	    $exception = new \Exception();
	    $lastTrace = $exception->getTrace()[0];
	    $file = $lastTrace['file'];
	    $line = $lastTrace['line'];

		$fileCodes = is_file($file) ? file($file) : '读取失败';
	    $code = '(无法获取脚本内容)';
	    if($fileCodes != ''){
	        $matchedCodes = [];
	        $lineScript = $fileCodes[$line - 1];
	        if(preg_match('/debug.*\(.*\)(?= *;)/i', $lineScript, $matchedCodes)){
	            $code = $matchedCodes[0];
	        }
	    }
	        
	    $showData = var_export($data, true);
	        
	    if($isAjax){
	        header('Content-type:application/json;charset=utf-8');
	        exit(json_encode(array(
	            'file' => $file,
	            'line' => $line,
	            'dataStr' => $showData,
	            'data' => $data,
	        )));
	    }else{
	        $dataType = gettype($data);
	        $backLink = '';
	        if(isset($_SERVER['HTTP_REFERER'])){
	            $backLink = '<a href="' . $_SERVER['HTTP_REFERER'] . '">返回(清空表单)</a>'
	                        . '<a href="javascript:history.back()">返回(保留表单状态)</a>';
	        }else{
	            $backLink = '<a href="javascript:history.back()">返回</a>';
	        }
	            
	        $length = 'no';
	        if(is_string($data)){
	            $length = strlen($data);
	        }
			
			if(PHP_SAPI !== 'cli'){
				$traceHtml = '';
				if($mode == 111 || $mode == 110){
					$traceHtml = '<div><p>运行轨迹:</p><pre>' . $exception->getTraceAsString() . '</pre></div>';
				}
				echo '
	<style>
	._wrapDebug{min-width:590px; margin:20px; padding:10px; font-size:14px; border:1px solid #000;}
	._wrapDebug span{color:#121E31; font-size:14px;}
	._wrapDebug font:first{color:green; font-size:14px;}
	._wrapDebug font:last{color:red; font-size:14px;}
	._wrapDebug pre{font-size:14px;}
	._wrapDebug p{background:#92E287;}
	._wrapDebug a{margin-left:20px;}
	</style>
	<div class="_wrapDebug">================= 新的调试点： 
	    <span>$debugCount</span> ========================<br />
	    <font>$file</font> 第 $line 行<br />
	    <font>$code</font><br />
	    调试输出内容:<br />
	    类型：$dataType<br />
	    字符串长度：$length<br />
	    值:<br />
	    <pre><p>$showData</p></pre>
	    $backLink
	    <a href="javascript:location.reload()">重新请求本页</a>
	    $traceHtml
	</div>
	EOL';
			}else{
				$traceContent = '';
				if($mode == 111 || $mode == 110){
					$traceContent = $exception->getTraceAsString();
				}
				$debugContent = '<<<EOL
	============ 新的调试点：$debugCount ============<br />
	$file:$line
	$code
	data type: $dataType
	string length: $length
	value:
	$showData

	$traceContent
	';
				echo $debugContent;
			}
	    }

	    ($mode == 11 || $mode == 111) && exit;
}


/**
 * 使对应导航栏高亮
 * @param  [type] $str [description]
 * @param  [type] $fun [description]
 * @return [type]      [description]
 */
function aside($str,$fun){
	if ($str==$fun) {
		echo 'class="fh5co-active"';
	}
	
}

function admin_aside($str,$fun){
	if ($str==$fun) {
		echo 'class="active"';
	}
}

/**
 * 显示对应用户头像
 * @param  [type] $logo [description]
 * @return [type]       [description]
 */
function logo($logo){
	if ($logo=session('img_url')) {
		echo 'src="'.$logo.'"';
	}else{
		echo 'src="__static__/images/logo-colored.png"';
	}
}

/**
 * 初始化邮件发送函数
 * @param  [type] $mail [description]
 * @param  [type] $data [description]
 * @return [type]       [description]
 */
function init_mail($mail,$data){

		$mailto=$data['mailto'];
		$tpl=$data['tpl'];
		

		// $mail->SMTPDebug = 3;                               // Enable verbose debug output
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = config('smtpserver');  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = config('smtpusermail');                 // SMTP username
		$mail->Password = config('smtppass');                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = config('smtpserverport');                                    // TCP port to connect to
		$mail->setFrom(config('smtpusermail'), 'www.zhongyilove.com');
		$mail->addAddress($mailto, 'User');     // Add a recipient
		$mail->addReplyTo(config('smtpusermail'), 'www.zhongyilove.com');//回复邮件地址
		$mail->isHTML(true);    
		switch ($tpl) {
			case 'mailReg':
				$token=$data['token'];
				$mail->Subject = '众一互联网用户注册邮箱验证';
				$mail->Body    = "亲爱的：".$mailto."<br/>感谢您在我站注册了新帐号。<br/>请点击链接激活您的帐号。<br/><a href='".config('reg_url')."?verify=".$token."' target='_blank'>".config('reg_url')."?verify=".$token."</a><br/>如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接24小时内有效。<br/>如果此次激活请求非你本人所发，请忽略本邮件。<br/><p style='text-align:right'>-------- www.jiangyang.me 敬上</p>";
				$mail->AltBody = '这是非html邮件客户机的纯文本';
				break;

			case 'suggest':
				$content=$data['content'];
				$mail->Subject = '邀请您参与《用户体验改善计划》';
				$mail->Body    = "亲爱的：".$mailto."<br/>您发送 的内容是：".$content."<br/><p></p>";
				$mail->AltBody = '这是非html邮件客户机的纯文本';
				break;
			case 'suggest2':
				$mail->Subject = '邀请您参与《用户体验改善计划》';
				$mail->Body    = "亲爱的：".$mailto."<br/>感谢您使用本网站。<br/>本站诚恳的邀请您参与我们的用户体验改善计划<br/>点击链接即可参与<br><a href='".config('reg_url')."?verify=".$token."' target='_blank'>".config('reg_url')."?verify=".$token."</a><br/>如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接24小时内有效。<br/><p style='text-align:right'>-------- www.jiangyang.me 敬上</p>";
				$mail->AltBody = '这是非html邮件客户机的纯文本';
				break;
			default:
				# code...
				break;
		}
		return $mail;
}