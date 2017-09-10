<?php
namespace app\index\model;

class NewsInfo extends \think\Model{
	function saveNewsInfo($data){
		if (!$this->where('st_id',$data['st_id'])->find()) {
			$this->insert($data);
		}
	}
	function show($where){
		return $this->where($where)->find();
	}

	function showList(){
		return $this->field('st_id,title,time')->order('time desc')->limit(30)->select();
	}
	function showHtml($st_id){
		return $this->field('html')->where('st_id',$st_id)->find();
	}

	function showNewsInfo($st_id){
		return $this->where('st_id',$st_id)->find();
	}
	function saveNewsInfoTime($data){
		$this->where('st_id',$data['st_id'])->update($data);
	}
}