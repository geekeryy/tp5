<?php
namespace Reptile;

class JsjNews{

	function updateNews(){

			$news_info=model('NewsInfo');

			$news=$news_info->show(array('st_id'=>'636404542540491398'));
			$news=json_decode(json_encode($news),true);
			return htmlspecialchars_decode($news['html']);
			    // var_dump($content); 

	}

	function updateNews1(){
		// return date('Y-m-d');
			$param['FolderId']='636053899667064406';
			$param['IsFullText']='0';
			$param['IsImg']='0';
			$param['SearchId']='';
			$param['PageNum']='1';
			$param['TabId']='0';
			$param['action']='GetItems';
			$param['callback']='fn_id_d693e5de_70ba_4d62_9dec_56dd6747aea1';
			$param['kw']='';

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
				$data['st_id']=$st_id;
				$data['html']=$content;	
				$data['time']=$value['time'];
				$data['title']=$value['title'];
				$news_info->saveNewsInfo($data);
			}


				$news=$news_info->showNewsInfo($st_id);
				$news=json_decode(json_encode($news),true);
				// return $news;
				return htmlspecialchars_decode($news['html']);
			    var_dump($content); 
	}

}