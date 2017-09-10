<?php
namespace Reptile;

class JsjNews{

	/**
	 * 更新计算机学院通知公告
	 * @param  [type] $type [description]
	 * @return [type]       [description]
	 */
	function updateNews($type){
// $type='hxxy';
		$test=model('Test');
		$res=$test->getNum();
		$res=json_decode(json_encode($res),true);
		$type=$res['tag'];
		$start=$res['page'];
		// return $start;
			//通知公告636053899667064406
			
			//考务信息636179414599214749
			
			// if ($type='tzgg') {
			// 	$param['FolderId']='636053899667064406';
			// }elseif ($type='kwxx') {
			// 	$param['FolderId']='636179414599214749';
			// }else{
			// 	$param['FolderId']='636060848519078056';
			// }
			$param['FolderId']='';
			$param['IsFullText']='0';
			$param['IsImg']='0';
			$param['SearchId']='';
			$param['PageNum']='2';
			$param['TabId']='0';
			$param['action']='GetItems';
			$param['callback']='fn_id_4afb57b9_8012_4fa7_9b56_1288237056f2';
			$param['kw']='';
			$end=$start+2;
			// $param['PageNum']=$end;

			// return $end;
		for ($i=$start; $i < $end ; $i++) { 

			$param['PageNum']=($i+1);

			$url='http://'.$type.'.suse.edu.cn/_rest/st/ajax_st_app_news.ashx';
			$ch = curl_init($url);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);//设定返回的数据是否自动显示
		    curl_setopt($ch, CURLOPT_HEADER, 0);//设定是否显示头信 息
		    curl_setopt($ch, CURLOPT_NOBODY, false);//设定是否输出页面 内容
		    curl_setopt($ch,CURLOPT_POST, 1);
		    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		    curl_setopt($ch,CURLOPT_POSTFIELDS, $param); //提交查询信息
		    $content =curl_exec($ch);
		    curl_close($ch);
		    // return $content;
		    $hdp = new htmlDomParser();	
			$html=$hdp->str_get_html($content);//创建DOM

			$info=array();
			$item=$html->find('.div_item');

			foreach ($item as $value1) {
				$e=$value1->find('.div_itemtitle',0);
				// if ($e->find('div',0)->innertext()=='2017-08-24') {
					$arr1=explode('?StId=st_app_news_i_x', $e->find('a',0)->href);
					if (!empty($arr1['1'])) {
						$info[$arr1['1']]['st_id']=$arr1['1'];
						$info[$arr1['1']]['time']=$e->find('div',0)->innertext();
						$info[$arr1['1']]['title']=$e->find('a',0)->innertext();
					}

				// }
			}
			// return var_dump($info); 
			$news_info=model('NewsInfo');
			foreach ($info as $key => $value) {
				$st_id = $key;
				$ch = curl_init('http://'.$type.'.suse.edu.cn/_wx/_wx_home_news_i.aspx?iid='.$st_id);
				curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);//设定返回的数据是否自动显示
			    curl_setopt($ch, CURLOPT_HEADER, 0);//设定是否显示头信 息
			    curl_setopt($ch, CURLOPT_NOBODY, false);//设定是否输出页面 内容
			    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			    $content =curl_exec($ch);
			    // return $content;
			    $content=str_replace('/_db_file/news_x', 'http://'.$type.'.suse.edu.cn/_db_file/news_x', $content);
			    $content=str_replace('/wx/', 'http://mp.weixin.qq.com/mp/getmasssendmsg?__biz=MzIzNzY0MTk3OA==#wechat_webview_type=1&wechat_redirect', $content);

			    curl_close($ch);
				$content=htmlspecialchars($content);


			    $content=str_replace('href=\'/_wx/_wx_home_albums.aspx\'&gt;图片', 'href=\'http://www.jiangyang.me/index/index/suselogin\'&gt;教务管理系统', $content);
			    $content=str_replace('href=\'/_wx/_wx_home_news.aspx?fid=&amp;kw=\'&gt;站内信息', 'href=\'http://www.jiangyang.me/index/index/jcclogin\'&gt;计财处', $content);
			    $content=str_replace('href=\'/_wx/_wx_home_more.aspx\'&gt;更多...', 'href=\'http://www.jiangyang.me/index/index/more\'&gt;更多...', $content);
			    $content=str_replace('&gt;&amp;lt;&amp;lt;&amp;nbsp;&lt;/a&gt;', ' href=\'http://www.jiangyang.me/index/index/more\' &gt;&amp;lt;&amp;lt;&amp;nbsp;&lt;/a&gt;', $content);
			    $content=str_replace('=\'/_tools/', '=\'http://'.$type.'.suse.edu.cn/_tools/', $content);
			    $content=str_replace('href=\'/_base_wx', 'href=\'http://'.$type.'.suse.edu.cn/_base_wx', $content);
			    $content=str_replace('src=&quot;/_tools/ue143', 'src=&quot;http://'.$type.'.suse.edu.cn/_tools/ue143', $content);

	
				$data['st_id']=$st_id;
				$data['html']=$content;	
				$data['time']=$value['time'];
				$data['title']=$value['title'];
				$data['type']=$type;
				// return htmlspecialchars_decode($data['html']);
				$news_info->saveNewsInfo($data);

				

			}
				
		}

		$test=model('Test');
		$test->saveNum(array('page'=>$end,'tag'=>$type));
	}


	/**
	 * 更新计算机学院通知公告
	 * @return [type] [description]
	 */
	function updateNews122(){

			$param['FolderId']='636053899667064406';
			$param['IsFullText']='0';
			$param['IsImg']='0';
			$param['SearchId']='';
			$param['PageNum']='1';
			$param['TabId']='0';
			$param['action']='GetItems';
			$param['callback']='fn_id_d693e5de_70ba_4d62_9dec_56dd6747aea1';
			$param['kw']='';
			// $url='http://jsj.suse.edu.cn/_home/home_index_ajax.ashx';

			$url='http://jsj.suse.edu.cn/_rest/st/ajax_st_app_news.ashx';
			$ch = curl_init($url);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);//设定返回的数据是否自动显示
		    curl_setopt($ch, CURLOPT_HEADER, 0);//设定是否显示头信 息
		    curl_setopt($ch, CURLOPT_NOBODY, false);//设定是否输出页面 内容
		    curl_setopt($ch,CURLOPT_POST, 1);
		    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		    curl_setopt($ch,CURLOPT_POSTFIELDS, $param); //提交查询信息
		    $content =curl_exec($ch);
		    curl_close($ch);
		    $hdp = new htmlDomParser();	
			$html=$hdp->str_get_html($content);//创建DOM
			$info=array();
			$item=$html->find('.div_item');

			foreach ($item as $value) {
				$e=$value->find('.div_itemtitle',0);
				if ($e->find('div',0)->innertext()==date('Y-m-d')) {
					$arr1=explode('?StId=st_app_news_i_x', $e->find('a',0)->href);
					$info[$arr1['1']]['st_id']=$arr1['1'];
					$info[$arr1['1']]['time']=$e->find('div',0)->innertext();
					$info[$arr1['1']]['title']=$e->find('a',0)->innertext();
				}
			}

			$news_info=model('NewsInfo');
			foreach ($info as $key => $value) {
				$st_id = $key;
				$ch = curl_init('http://jsj.suse.edu.cn/_wx/_wx_home_news_i.aspx?iid='.$st_id);
				curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);//设定返回的数据是否自动显示
			    curl_setopt($ch, CURLOPT_HEADER, 0);//设定是否显示头信 息
			    curl_setopt($ch, CURLOPT_NOBODY, false);//设定是否输出页面 内容
			    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			    $content =curl_exec($ch);
			    $content=str_replace('/_db_file/news_x', 'http://jsj.suse.edu.cn/_db_file/news_x', $content);
			    $content=str_replace('/wx/', 'http://mp.weixin.qq.com/mp/getmasssendmsg?__biz=MzIzNzY0MTk3OA==#wechat_webview_type=1&wechat_redirect', $content);

			    curl_close($ch);
				$content=htmlspecialchars($content);


			    $content=str_replace('href=\'/_wx/_wx_home_albums.aspx\'&gt;图片', 'href=\'http://www.jiangyang.me/index/index/suselogin\'&gt;教务管理系统', $content);
			    $content=str_replace('href=\'/_wx/_wx_home_news.aspx?fid=&amp;kw=\'&gt;站内信息', 'href=\'http://www.jiangyang.me/index/index/jcclogin\'&gt;计财处', $content);
			    $content=str_replace('href=\'/_wx/_wx_home_more.aspx\'&gt;更多...', 'href=\'http://www.jiangyang.me/index/index/more\'&gt;更多...', $content);
			    $content=str_replace('&gt;&amp;lt;&amp;lt;&amp;nbsp;&lt;/a&gt;', ' href=\'http://www.jiangyang.me/index/index/more\' &gt;&amp;lt;&amp;lt;&amp;nbsp;&lt;/a&gt;', $content);
			    $content=str_replace('=\'/_tools/', '=\'http://jsj.suse.edu.cn/_tools/', $content);
			    $content=str_replace('href=\'/_base_wx', 'href=\'http://jsj.suse.edu.cn/_base_wx', $content);
			    $content=str_replace('src=&quot;/_tools/ue143', 'src=&quot;http://jsj.suse.edu.cn/_tools/ue143', $content);

	
				$data['st_id']=$st_id;
				$data['html']=$content;	
				$data['time']=$value['time'];
				$data['title']=$value['title'];
				$news_info->saveNewsInfo($data);

			}


				// $news=$news_info->showNewsInfo($st_id);
				// $news=json_decode(json_encode($news),true);
				// // return $news;
				// return htmlspecialchars_decode($news['html']);
			 //    var_dump($content); 
	}


	// href='/_wx/_wx_home_albums.aspx'&gt;图片

	// href='http://www.jiangyang.me/index/index/suselogin'&gt;教务管理系统

	// href='/_wx/_wx_home_news.aspx?fid=&amp;kw='&gt;站内信息

	// href='http://www.jiangyang.me/index/index/jcclogin'&gt;计财处
	// 
	// href='/_wx/_wx_home_more.aspx'&gt;更多...
	// 
	// href='http://www.jiangyang.me/index/index/more'&gt;更多...
	// 
	// &gt;&amp;lt;&amp;lt;&amp;nbsp;&lt;/a&gt;
	// 
	//  href='http://www.jiangyang.me/index/index/more' &gt;&amp;lt;&amp;lt;&amp;nbsp;&lt;/a&gt;
	//  
	//  ='/_tools/
	//  
	//  ='http://jsj.suse.edu.cn/_tools/
	//  
	//  href='/_base_wx
	//  
	//  href='http://jsj.suse.edu.cn/_base_wx
	//  
	//  src=&quot;/_tools/ue143
	//  
	//  src=&quot;http://jsj.suse.edu.cn/_tools/ue143

}