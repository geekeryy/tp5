<?php
namespace app\index\model;

class UserInfo extends \think\Model{
	//

	/*检查用户是否存在*/
	function findUser($data){
		$res=$this->where($data)->find();
		return $res;
	}
	/*普通账号注册*/
	function register($data){
		//
		$data['reg_time']=date('Y-m-d h:i:s',time());
		$data['last_time']=date('Y-m-d h:i:s',time());
		$data['openid']=md5(time().rand(100,999));
		$res=$this->where('account',$data['account'])->find();
		if (isset($res) && !empty($res)) {
			$res=3;
		}else{
			$res=$this->save($data);
		}
		return $res;

	}

	/*手机号注册*/
	function phoneReg($data){
		$data['state']=1;
		$data['account']=$data['mobile'];
		$data['reg_time']=date('Y-m-d h:i:s',time());
		$data['last_time']=date('Y-m-d h:i:s',time());
		$data['openid']=md5(time().rand(100,999));
		$res=$this->field('state')->where('account',$data['mobile'])->find();
		if (isset($res) && !empty($res)) {
			$res=3;
		}else{
			$res=$this->save($data);
		}
		return $res;
	}

	/*邮箱激活链接验证,并激活账户state=1*/
	function mailRegVarity($verify){
		$res=$this->where('openid',$verify)->find();
		if (isset($res) && !empty($res)) {
			$data=array('state'=>1);
			$res=$this->where('openid',$verify)->update($data);
		}else{
			$res=3;
		}
		return $res;
	}

	/*邮箱注册*/
	function mailReg($data){
		$data['state']=0;
		$data['account']=$data['email'];
		$data['reg_time']=date('Y-m-d h:i:s',time());
		$data['last_time']=date('Y-m-d h:i:s',time());
		// $data['openid']=substr(md5(time().rand(100,999)), 2);//控制器已经赋值
		// $res=$this->field('state')->where('account',$data['email'])->find();
		$res=$this->save($data);
		return $res;
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

		$res=$this->field('openid')->where('openid',$arr['openid'])->find();
		
		//如果存在用户，者刷新用户信息，否则注册用户信息
		if (isset($res['openid']) && !empty($res['openid'])) {
			//QQ登录，刷新用户信息
			$res=$this->where('openid',$res['openid'])->update($data);
			return $res;
		}else{
			//注册
			$data['reg_time']=date('Y-m-d h:i:s',time());
			//执行save多个的时候，只执行最后一条
			$res=$this->save($data);
			return $res;
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