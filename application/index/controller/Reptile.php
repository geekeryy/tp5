<?php
namespace app\index\controller;
use Reptile\htmlDomParser;
use Reptile\Suse;
class Reptile{


	/**
	 * 爬取计算机学院2005两至今所有新闻信息
	 * @return [type] [description]
	 */
	function test(){
		// $param['FolderId']='636053899667064406';
		// $param['IsFullText']='0';
		// $param['IsImg']='0';
		// $param['SearchId']='';
		// $param['PageNum']='1';
		// $param['TabId']='0';
		// $param['action']='GetItems';
		// $param['callback']='fn_id_d693e5de_70ba_4d62_9dec_56dd6747aea1';
		// $param['kw']='';

		// for ($i=0; $i < 51; $i++) { 
		// 	$param['PageNum']=($i+1);
		// 	$url='http://jsj.suse.edu.cn/_rest/st/ajax_st_app_news.ashx';
		// 	$ch = curl_init($url);
		// 	curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);//设定返回的数据是否自动显示
		//     curl_setopt($ch, CURLOPT_HEADER, 0);//设定是否显示头信 息
		//     curl_setopt($ch, CURLOPT_NOBODY, false);//设定是否输出页面 内容
		//     curl_setopt($ch,CURLOPT_POST, 1);
		//     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		//     curl_setopt($ch,CURLOPT_POSTFIELDS, $param); //提交查询信息
		//     $content =curl_exec($ch);
		//     curl_close($ch);
		//     $hdp = new htmlDomParser();	
		// 	$html=$hdp->str_get_html($content);//创建DOM
		// 	$info=array();
		// 	$item=$html->find('.div_item');
		// 	$news_info=model('NewsInfo');
		// 	foreach ($item as $value) {
		// 		$e=$value->find('.div_itemtitle',0);
		// 		$info['time']=$e->find('div',0)->innertext();
		// 		$info['title']=$e->find('a',0)->innertext();
		// 		$arr1=explode('?StId=st_app_news_i_x', $e->find('a',0)->href);
		// 		$info['st_id']=$arr1['1'];
		// 		$news_info->saveNewsInfoTime($info);
		// 	}
				
				
				// return var_dump($info);

			



		// 	$e=$html->find('a');
		// 	$j=0;
		// 	foreach ($e as $value) {
		// 		$arr1=explode('?StId=st_app_news_i_x', $value->href);
		// 		if (isset($arr1['1'])) {
		// 			$arr[$j]=$arr1['1'];
		// 			$j++;
		// 		}
		// 	}
		// 	foreach ($arr as $key => $value) {
		// 		$st_id = $value;
		// 		$ch = curl_init('http://jsj.suse.edu.cn/_wx/_wx_home_news_i.aspx?iid='.$st_id);
		// 		curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);//设定返回的数据是否自动显示
		// 	    curl_setopt($ch, CURLOPT_HEADER, 0);//设定是否显示头信 息
		// 	    curl_setopt($ch, CURLOPT_NOBODY, false);//设定是否输出页面 内容
		// 	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		// 	    $content =curl_exec($ch);
		// 	    curl_close($ch);
		// 		$content=htmlspecialchars($content);
		// 		$data['st_id']=$st_id;
		// 		$data['html']=$content;
		// 		$news_info=model('NewsInfo');
		// 		$news_info->saveNewsInfo($data);
		// 	}
		// }





		// $news=$news_info->showNewsInfo($st_id);
		// $news=json_decode(json_encode($news),true);
		// return $news;
		// return htmlspecialchars_decode($news['html']);
	    // var_dump($content); 


	}

	function test7(){
		// header('Content-Type:html/text;charset:utf-8');
		$url='http://61.139.105.138/default2.aspx';
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//0获取后直接打印出来
	    $content =curl_exec($ch);
	    $content =mb_convert_encoding( $content ,'utf-8', array('Unicode','ASCII','GB2312','GBK','UTF-8'));
	    curl_close($ch);
	    $hdp = new htmlDomParser();	
		$html=$hdp->str_get_html($content);//创建DOM
		$e=$html->find('a',0);
		var_dump($e->innertext());
	}



	function info(){
		$act='';
		if (input('param.act')) {
		   $act = input('param.act');
		}
		// var_dump($act);exit();
	// 15111040122
	// shenxin19971211
	// 
	// 15111040116
	// aspire1998
	// 
	// 15111040134
	// 526982371bx
	
		// $user = '14101070205';//用户名
		// $password = 'a1126254578';//密码
		
		// $user = '15111040122';//用户名
		// $password = 'shenxin19971211';//密码
		
		// $user = '15111040116';//用户名
		// $password = 'aspire1998';//密码

		$user = '15111040134';//用户名
		$password = '526982371bx';//密码

		$suse=new Suse($user,$password);

		switch($act)
		{
		  case 'login':
		  	  $suse->getViewstate();
			  $suse->curlLogin();
		      $content = $suse->getInfo();

		      echo $content;

				$hdp = new htmlDomParser();
				$html=$hdp->str_get_html($content);//创建DOM

				// $item2=$html->find('#Table2',0);
					// echo $item2->innertext();
					// selected="selected"
					// 
				

				
				$i=0;
				$item1=$html->find('#Table1 tr');
				foreach ($item1 as $value) {
					foreach ($value->find('td') as $value2) {
						if (strstr($value2->innertext(),'<br>')) {
							echo $value2->innertext();
							$i++;
							session($i,$value2->innertext());
						}
					}
				}

echo $i;
var_dump(session(''));
		      break;
		   case 'authcode':
		      // Content-Type 验证码的图片类型
		      header('Content-Type:image/png charset=gb2312');
		      $suse->showAuthcode();
		      exit;
		     break;
		}


	}

	function test6(){
		$student_info=model('StudentInfo');
		$res=$student_info->showClasses();
		// $res=json_decode(json_encode($res),true);
		var_dump($res);
	}

	function test5(){
			header("Content-Type:text/html;charset=utf-8");
			$url='nose.wyysdsa.cn/act/getFudaoyuanResult.html';
			$student_info=model('StudentInfo');
			
			// 17763-6396
			$end=17763;
			$start=6396;
			$j=0;
			$arr=array();
			$res=array();
			// for ($i=6396; $i < $end; $i+=51) { 
			// 	if ($arr=$student_info->show(array('id'=>$i))) {
			// 		// $res[$j]=$arr['0'];
				
			// 		$arr=json_decode(json_encode($arr),true);
			// 		// var_dump($arr[0]);
			// 		$res[$j]=$arr[0];
			// 		// $res[$j]=json_decode(json_encode($res[$j]),true);

			// 		$j++;
			// 	}

			// }
			// var_dump($res);
			// exit();
			
			// $list=$res;
			$list=$student_info->showClasses();
			$data=array();
			foreach ($list as $key => $value) {

					$number=$value['number'];
					$post='zkzh='.$number;
				    $curl = curl_init();//初始化curl模块 
				    curl_setopt($curl, CURLOPT_URL, $url);//登录提交的地址 
				    curl_setopt($curl, CURLOPT_HEADER, 0);//是否显示头信息 
				    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//是否自动显示返回的信息 
				    // curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie); //设置Cookie信息保存在指定的文件中 
				    curl_setopt($curl, CURLOPT_POST, 1);//post方式提交 
				    curl_setopt($curl, CURLOPT_POSTFIELDS,$post);//要提交的信息 
				    curl_exec($curl);//执行cURL 
				    $rs = curl_exec($curl); //执行cURL抓取页面内容 
				    curl_close($curl);//关闭cURL资源，并且释放系统资源 
				    $arr=json_decode($rs,true);
				    if ($arr) {
				    	// echo $number;
					    // var_dump($arr);
					    $arr1['number']=$number;
					    
					    $text1=explode('辅导员名字：', $arr['text']);

					    $text2=explode('辅导员电话：', $text1['1']);

					    // $arr1['name']=$text2['0'];
					    $arr1['phone']=$text2['1'];
					    $arr1['classes']=$value['classes'];
					    $data[$key]=$arr1;
				    }else{
				    	echo $number.'error<br>';
				    }
				    
				}
				// var_dump($data);
				$teacher_info_copy=model('TeacherInfoCopy');
				$teacher_info_copy->saveInfo($data);
				echo 'ok';
			    // echo mb_convert_encoding($rs, "utf-8");
			    // echo iconv('utf-8','UCS-2BE',$rs);
			    // var_dump();
	}

	function test4(){
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
	function test3(){
		// 新建一个Dom实例
		$hdp = new htmlDomParser();
		$url='http://zigong.ganji.com/shouji/?original=%E6%89%8B%E6%9C%BA&websearchkw=%E4%BA%8C%E6%89%8B%E6%89%8B%E6%9C%BA';
		$url='http://www.doumi.com/zigong/';
		$url='http://www.ebrun.com/20170828/244333.shtml';
		$url='http://news.mydrivers.com/1/546/546136.htm';
				$Curl=curl_init();//实例化cURL
				curl_setopt($Curl, CURLOPT_URL, $url);//初始化路径
				curl_setopt($Curl, CURLOPT_RETURNTRANSFER, 1);//0获取后直接打印出来
				curl_setopt($Curl, CURLOPT_HEADER, 0);//0关闭打印相应头,直接打印需为1,
				$result=curl_exec($Curl);//执行一个cURL会话
				curl_close($Curl);//关闭cURL会话
				$html=$hdp->str_get_html($result);//创建DOM
				$item=$html->find('.cmsDiv');
				foreach ($item as $value) {
					echo '1';
					echo $value->innertext();
				}
				// echo $result;
					// $i=0;
					// $data=array();
					// foreach ($html->find('.div_content tr') as $tr) {
					// 	$data[$i]['campus']=$tr->find('td span',0)->innertext();
					// 	$data[$i]['number']=$tr->find('td span',1)->innertext();
					// 	$data[$i]['name']=$tr->find('td span',2)->innertext();
					// 	$data[$i]['sex']=$tr->find('td span',3)->innertext();
					// 	$data[$i]['college']=$tr->find('td span',4)->innertext();
					// 	$data[$i]['major']=$tr->find('td span',5)->innertext();
					// 	$data[$i]['student_id']=$tr->find('td span',6)->innertext();
					// 	$data[$i]['classes']=$tr->find('td span',7)->innertext();
					// 	$data[$i]['dorm']=$tr->find('td span',8)->innertext();
					// 	$i++;
					// }
				$html->clear(); 
				unset($html);
		
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
		// 
		// 
		// 
		// 
		// 
		// 
		// 
}