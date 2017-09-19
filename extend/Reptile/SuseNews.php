<?php
namespace Reptile;

class SuseNews{

	/**
	 * 更新所有学院通知公告
	 * @param  [type] $type [description]
	 * @return [type]       [description]
	 */
	function updateNews($typearr){
			// $typearr=array('rwxy');
			$param['FolderId']='';
			$param['IsFullText']='0';
			$param['IsImg']='0';
			$param['SearchId']='';
			$param['PageNum']='1';
			$param['TabId']='0';
			$param['action']='GetItems';
			$param['callback']='fn_id_4afb57b9_8012_4fa7_9b56_1288237056f2';
			$param['kw']='';
		for ($i=0; $i < 3 ; $i++) { 
			$param['PageNum']=($i+1);
			foreach ($typearr as $type) {

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
					$time=$e->find('div',0)->innertext();
					if ($time==date('Y-m-d')) {
						$a=$e->find('a',0);
						$arr1=explode('?StId=st_app_news_i_x', $a->href);
						if (!empty($arr1['1'])) {
							$info[$arr1['1']]['time']=$time;
							$info[$arr1['1']]['title']=$a->innertext();
						}
					}
				}
				// return var_dump($info);
				$news_info=model('NewsInfo');
				foreach ($info as $key => $value) {
					$ch = curl_init('http://'.$type.'.suse.edu.cn/_wx/_wx_home_news_i.aspx?iid='.$key);
					curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);//设定返回的数据是否自动显示
				    curl_setopt($ch, CURLOPT_HEADER, 0);//设定是否显示头信 息
				    curl_setopt($ch, CURLOPT_NOBODY, false);//设定是否输出页面 内容
				    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
				    $content =curl_exec($ch);
				    $content=str_replace('"/_db_file/news_x', '"http://'.$type.'.suse.edu.cn/_db_file/news_x', $content);
				    $content=str_replace('\'/_db_file/news_x', '\'http://'.$type.'.suse.edu.cn/_db_file/news_x', $content);
				    $content=str_replace('/wx/', 'http://mp.weixin.qq.com/mp/getmasssendmsg?__biz=MzIzNzY0MTk3OA==#wechat_webview_type=1&wechat_redirect', $content);
				    curl_close($ch);

				    $content=str_replace('href=\'/_wx/_wx_home_albums.aspx\'>图片', 'href=\'http://www.jiangyang.me/index/index/suselogin\'>教务管理系统', $content);
				    $content=str_replace('href=\'/_wx/_wx_home_news.aspx?fid=&kw=\'>站内信息', 'href=\'http://www.jiangyang.me/index/index/jcclogin\'>计财处', $content);
				    $content=str_replace('href=\'/_wx/_wx_home_more.aspx\'>更多', 'href=\'http://www.jiangyang.me/index/index/more\'>更多', $content);
				    $content=str_replace('=\'/_tools/', '=\'http://'.$type.'.suse.edu.cn/_tools/', $content);
				    $content=str_replace('href=\'/_base_wx', 'href=\'http://'.$type.'.suse.edu.cn/_base_wx', $content);
				    $content=str_replace('src="/_tools/ue143', 'src="http://'.$type.'.suse.edu.cn/_tools/ue143', $content);

				    $content=htmlspecialchars($content);

					$data['st_id']=$key;
					$data['html']=$content;	
					$data['time']=$value['time'];
					$data['title']=$value['title'];
					$data['type']=$type;
					// var_dump($data);
					$news_info->saveNewsInfo($data);

				}
			}
		}
	}


	/**
	 * 更新学院通知公告
	 * @return [type] [description]
	 */
	function updateNews122(){

			$type='jsj';
			$test=model('Test');
			$res=$test->getNum();
			$res=json_decode(json_encode($res),true);
			$type=$res['tag'];
			$start=$res['page'];
		// return $start;
			$param['FolderId']='';
			$param['IsFullText']='0';
			$param['IsImg']='0';
			$param['SearchId']='';
			$param['PageNum']='1';
			$param['TabId']='0';
			$param['action']='GetItems';
			$param['callback']='fn_id_4afb57b9_8012_4fa7_9b56_1288237056f2';
			$param['kw']='';
			$end=$start+2;
			$param['PageNum']=$end;

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
				if ($e->find('div',0)->innertext()=='2017-09-08') {
					$arr1=explode('?StId=st_app_news_i_x', $e->find('a',0)->href);
					if (!empty($arr1['1'])) {
						$info[$arr1['1']]['st_id']=$arr1['1'];
						$info[$arr1['1']]['time']=$e->find('div',0)->innertext();
						$info[$arr1['1']]['title']=$e->find('a',0)->innertext();
					}
				}
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
			    $content=str_replace('"/_db_file/news_x', '"http://'.$type.'.suse.edu.cn/_db_file/news_x', $content);
			    $content=str_replace('/wx/', 'http://mp.weixin.qq.com/mp/getmasssendmsg?__biz=MzIzNzY0MTk3OA==#wechat_webview_type=1&wechat_redirect', $content);
// return $content;
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

	