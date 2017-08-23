<?php
namespace app\admin\model;

class ViewInfo extends \think\Model{

	/**
	 * 如果session_id不存在，则保存用户访问信息
	 * 一次会话代表一次访问
	 * @return [type] [description]
	 */
	function view(){
		//每个会话只执行一次
		if (!$this->where('session_id',session_id())->find()) {
			$data['ip']=request()->ip();
			$data['session_id']=session_id();
			$data['location']='保留';
			$data['time']=date("Y-m-d h:i:s",time());
			$res=$this->save($data);
		}
		
	}
}