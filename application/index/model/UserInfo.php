<?php
namespace app\index\model;

class UserInfo extends \think\Model{
	//

	function phoneReg($data){
		$data['state']=1;
		$data['account']=$data['mobile'];
		$data['reg_time']=date('Y-m-d h:i:s',time());
		$data['last_time']=date('Y-m-d h:i:s',time());
		$data['openid']=substr(md5(time().rand(100,999)), 2);
		return $this->save($data);
	}
	/*邮箱激活链接验证*/
	function mailRegVarity($verify){
		$res=$this->where('openid',$verify)->find();
		if (isset($res) && !empty($res)) {
			$data=array('state'=>1);
			$this->where('openid',$verify)->update($data);
		}
		return $res;
	}
	/*邮箱注册*/
	function mailReg($data){
		$data['state']=0;
		$data['account']=$data['email'];
		$data['reg_time']=date('Y-m-d h:i:s',time());
		$data['last_time']=date('Y-m-d h:i:s',time());
		return $this->save($data);
	}

	/*1.判断用户是登录还是注册
	 *2.实现用户每次登录，刷新一次信息
	 */
	function qq_saveUser($arr){
		//
		$data['state']=1;
		$data['openid']=$arr['openid'];
		$data['nickname']=$arr['info']['nickname'];
		$data['sex']=$arr['info']['gender'];
		$data['province']=$arr['info']['province'];
		$data['city']=$arr['info']['city'];
		$data['img_url']=$arr['info']['figureurl_qq_2'];
		
		$data['last_time']=date('Y-m-d h:i:s',time());

		$res=$this->field('openid')->where('openid',$arr['openid'])->select();
		
		//如果存在用户，者刷新用户信息，否则注册用户信息
		if (isset($res[0]['openid']) && !empty($res[0]['openid'])) {
			//QQ登录，刷新用户信息
			$this->where('openid',$res[0]['openid'])->update($data);
		}else{
			//注册
			$data['reg_time']=date('Y-m-d h:i:s',time());
			//执行save多个的时候，只执行最后一条
			$this->save($data);
		}
	}

	/*更新邮箱数据*/
	function seveMail($email){
		$data=array('email'=>$email);
		$this->update($data);
	}

	/*更新手机数据*/
	function sevePhone($mobile){
		$data=array('mobile'=>$mobile);
		$this->update($data);
	}
}