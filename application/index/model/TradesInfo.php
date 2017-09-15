<?php
namespace app\index\model;

class TradesInfo extends \think\Model{

	/**
	 * 更新保存交易信息
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	function saveTradesInfo($data){
		//数据过滤
		unset($data['items']);
		if (!$this->where('order_no',$data['order_no'])->find()) {
			$this->save($data);
		}else{
			$this->where('order_no',$data['order_no'])->update($data);
		}
	}

	/**
	 * 获取个人/团队月/日销售额
	 * @param  [type] $where [phone/item_id]
	 * @return [type]        [description]
	 */
	function getSales($data){
		$where['state']=5;
		$where['phone']=$data['phone'];
		if ($data['time']=='month') {
			// 一个月前的时间戳
			$date=date('Y-m-d H:i:s',time()-2592000);
			// $date='2017-01-18 00:00:00';
		}else{
			//一天前的时间戳
			$date=date('Y-m-d H:i:s',time()-86400);
			// $date='2017-01-19 00:00:00';
		}
		
		// $date='2017-01-19 00:00:00';
		// $res=$this->field('money')->where('state',$where['state'])->where('phone',$where['phone'])->where('created_at','>',$date)->select();
		$res=$this->field('money')->where('state',$where['state'])->where('phone','in',$where['phone'])->where('created_at','>',$date)->select();
		$res=json_decode(json_encode($res),true);
		return $res;
	}

	
}