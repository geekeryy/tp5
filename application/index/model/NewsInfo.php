<?php
namespace app\index\model;

class NewsInfo extends \think\Model{

	/**
	 * 保存学院新闻信息
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	function saveNewsInfo($data){
		if (!$this->where('st_id',$data['st_id'])->find()) {
			$this->insert($data);
		// }else{
			// $this->where('st_id',$data['st_id'])->update($data);
		}
	}

	/**
	 * show函数
	 * @param  [type] $where [description]
	 * @return [type]        [description]
	 */
	function show($where){
		return $this->where($where)->find();
	}

	/**
	 * 展示指定学院的新闻列表
	 * @param  [type] $xy [description]
	 * @return [type]     [description]
	 */
	function showList($xy){
		return $this->field('st_id,title,time')->where('type',$xy)->order('time desc')->limit(100)->select();
	}

	/**
	 * 展示指定id的新闻
	 * @param  [type] $st_id [description]
	 * @return [type]        [description]
	 */
	function showHtml($st_id){
		$where['st_id']=$st_id;
		return $this->field('html')->where($where)->find();
	}

	/**
	 * [showNewsInfo description]
	 * @param  [type] $st_id [description]
	 * @return [type]        [description]
	 */
	function showNewsInfo($st_id){
		return $this->where('st_id',$st_id)->find();
	}

	/**
	 * [saveNewsInfoTime description]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	function saveNewsInfoTime($data){
		$this->where('st_id',$data['st_id'])->update($data);
	}
}