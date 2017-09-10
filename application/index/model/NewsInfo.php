<?php
namespace app\index\model;

class NewsInfo extends \think\Model{
	function saveNewsInfo($data){

		if (!$this->where('st_id',$data['st_id'])->find()) {
			$this->insert($data);
		// }else{
			// $this->where('st_id',$data['st_id'])->update($data);
		}
	}
	function show($where){
		return $this->where($where)->find();
	}

	function showList($xy){
		return $this->field('st_id,title,time')->where('type',$xy)->order('time desc')->limit(100)->select();
	}
	function showHtml($st_id){
		$where['st_id']=$st_id;
		return $this->field('html')->where('st_id','636076525985201798')->find();
	}

	function showNewsInfo($st_id){
		return $this->where('st_id',$st_id)->find();
	}
	function saveNewsInfoTime($data){
		$this->where('st_id',$data['st_id'])->update($data);
	}
}