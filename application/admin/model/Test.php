<?php
namespace app\admin\model;

class Test extends \think\Model{
	function test($data){

		// $res=$this->save(array('data'=>$data['openid']));
		$res=$this->save($data);
		return $res;
	}
	function show(){
		$res=$this->where('id','>',0)->select();
		return $res;
	}
	function trace(){
		$this->startTrans();
		try{
			$id=160;
			$this->destroy($id);
			$data['state']=1;
			if ($this->where('id',160)->update($data)) {
				$this->commit();
			}else{
				$this->rollback();
			}
			// 提交事务
			
		} catch (\think\Exception $e) {
			// 回滚事务
			$this->rollback();
		}
	}
}