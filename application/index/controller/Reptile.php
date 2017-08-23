<?php
namespace app\index\controller;
use Reptile\htmlDomParser;
class Reptile{
	function showInfo(){
		header("Content-Type:text/html;charset=utf-8");
		$student_info=model('StudentInfo');
		$res=$student_info->show();
		$res=json_decode(json_encode($res),true);
		foreach ($res as $key => $value) {
			$data[$value['dorm']]=$value['dorm'];
		}
		$reg='/\D/s';//匹配数字的正则表达式

        foreach ($data as $key => $value) {
        	$arr=explode('-', $data[$key]);
        	
        	// if (isset($arr['1']) && !empty($arr['1'])) {
        	// }else{
        	// 	$arr=explode('—', $data[$key]);
        	// 		if (isset($arr['1']) && !empty($arr['1'])) {
		       //  	}else{
		       //  		$arr=explode('--', $data[$key]);
		       //  	}	
        	// }
        	$result[$arr['0']]=$arr['0'];
        }

        var_dump($result);
		// var_dump($data);
	}
	function test(){
		// 新建一个Dom实例
		$hdp = new htmlDomParser();
		 

		// $url['index']='http://www.suse.edu.cn/p/59/';
		// 
		// $url['1']='http://www.suse.edu.cn/p/10/?StId=st_app_news_i_x636388310213262804';//自动化与信息学院
		// $url['2']='http://www.suse.edu.cn/p/10/?StId=st_app_news_i_x636387607302420548';//法学院
		// $url['3']='http://www.suse.edu.cn/p/10/?StId=st_app_news_i_x636387607269451011';//高端技术技能型
		// $url['4']='http://www.suse.edu.cn/p/10/?StId=st_app_news_i_x636387607242888431';//管理学院
		// $url['5']='http://www.suse.edu.cn/p/10/?StId=st_app_news_i_x636387607219450899';//化学工程学院
		// $url['6']='http://www.suse.edu.cn/p/10/?StId=st_app_news_i_x636387607194920470';//化学与环境工程
		// $url['7']='http://www.suse.edu.cn/p/10/?StId=st_app_news_i_x636387607173513751';//机械工程
		// $url['8']='http://www.suse.edu.cn/p/10/?StId=st_app_news_i_x636387607152888654';//计算机学院

		// $url['9']='http://www.suse.edu.cn/p/10/?StId=st_app_news_i_x636387607131794945';//教育与心理科学学院
		// $url['10']='http://www.suse.edu.cn/p/10/?StId=st_app_news_i_x636387607111169848';//经济学院
		// $url['11']='http://www.suse.edu.cn/p/10/?StId=st_app_news_i_x636387607088044854';//马克思主义学院
		// $url['12']='http://www.suse.edu.cn/p/10/?StId=st_app_news_i_x636387607066482280';//美术学院
		// $url['13']='http://www.suse.edu.cn/p/10/?StId=st_app_news_i_x636387607043670188';//人文学院
		// $url['14']='http://www.suse.edu.cn/p/10/?StId=st_app_news_i_x636387607020856857';//生物工程学院
		// $url['15']='http://www.suse.edu.cn/p/10/?StId=st_app_news_i_x636387606999138277';//数学与统计学院
		// $url['16']='http://www.suse.edu.cn/p/10/?StId=st_app_news_i_x636387606974294619';//体育学院
		// $url['17']='http://www.suse.edu.cn/p/10/?StId=st_app_news_i_x636387606923356977';//土木工程学院
		// $url['18']='http://www.suse.edu.cn/p/10/?StId=st_app_news_i_x636387606891481510';//外语学院
		// $url['1']='http://www.suse.edu.cn/p/10/?StId=st_app_news_i_x636387606867887747';//物理与电子工程学院
		// $url['0']='http://www.suse.edu.cn/p/10/?StId=st_app_news_i_x636387606835543924';//音乐学院
		

		foreach ($url as $key => $value) {
				$Curl=curl_init();//实例化cURL
				curl_setopt($Curl, CURLOPT_URL, $value);//初始化路径
				curl_setopt($Curl, CURLOPT_RETURNTRANSFER, 1);//0获取后直接打印出来
				curl_setopt($Curl, CURLOPT_HEADER, 0);//0关闭打印相应头,直接打印需为1,
				$result=curl_exec($Curl);//执行一个cURL会话
				curl_close($Curl);//关闭cURL会话
				$html=$hdp->str_get_html($result);//创建DOM
					$i=0;
					$data=array();
					foreach ($html->find('.div_content tr') as $tr) {
						$data[$i]['campus']=$tr->find('td span',0)->innertext();
						$data[$i]['number']=$tr->find('td span',1)->innertext();
						$data[$i]['name']=$tr->find('td span',2)->innertext();
						$data[$i]['sex']=$tr->find('td span',3)->innertext();
						$data[$i]['college']=$tr->find('td span',4)->innertext();
						$data[$i]['major']=$tr->find('td span',5)->innertext();
						$data[$i]['student_id']=$tr->find('td span',6)->innertext();
						$data[$i]['classes']=$tr->find('td span',7)->innertext();
						$data[$i]['dorm']=$tr->find('td span',8)->innertext();
						$i++;
					}
				$html->clear(); 
				unset($html);
				$student_info=model('StudentInfo');
				$res=$student_info->saveInfo($data);
		}
	}


	function test2(){
		header("Content-Type:text/html;charset=utf-8");
		 $ch = curl_init();
		 // 2. 设置选项，包括URL
		 $url="http://www.jb51.net/article/27282.htm";
		 curl_setopt($ch,CURLOPT_URL,$url);
		 curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		 curl_setopt($ch,CURLOPT_HEADER,0);
		 // 3. 执行并获取HTML文档内容
		 $output = curl_exec($ch);
		 $res=explode('>', $output);
		 // $keytitle= iconv("gb2312","utf-8",'123'); 
		 $status=1;
		 $charset=false;
		 foreach ($res as $key => $value) {
		 	// $keytitle[$key] = iconv("UTF-8","gb2312",$value); 
		 	$keytitle[$key] = mb_convert_encoding($value,"UTF-8",array('utf-8','gb2312','gbk','iso8859-1')); 
		 	// $keytitle[$key] = iconv("gb2312","UTF-8",$value); 
		 	// $charset=strstr($value,'charset=');
		 	if ($status) {
		 		$charset=strstr($value,'charset=');
		 		if ($charset) {
		 			$status=0;
		 		}
		 	}
		 }



		 $arr=explode('"', $charset);
		 var_dump($arr);
		 // echo $arr['1'];
		 echo $charset;
		 // var_dump($res);
		 var_dump($keytitle);
	}


	function getCharset(){
		//获取字符集
		$charset=false;
		if ($res=$html->find('meta')) {
			foreach ( $res as  $value) {
				if (!$charset) {
					//如果没有charset属性，则截取字符串
					if (!$value->charset) {
						$arr = explode("=", strstr($value->content, 'charset='));
						$charset = $arr['1'];
					}else{
						$charset = $value->charset;
					}	
				}
			}
		}else{
			$charset='utf-8';
		}
		

		echo $charset;
		//转换字符集
		$res=iconv($charset,"UTF-8",$result);

		// var_dump($res);
	}
}