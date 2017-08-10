<?php
namespace app\index\model;

class UserInfo extends \think\Model{
	//

	/**
	 * 查询用户
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	function findUser($data){
		$res=$this->where($data)->find();
		return $res;
	}

	function upLoginInfo($data){
		$arr['ip']=request()->ip();
		$arr['last_time']=date('Y-m-d h:i:s',time());
		$res=$this->where($data)->update($arr);
		return $res;
	}

	/**
	 * 用户账号密码登录
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	function login($data){
		$res=$this->where($data)->find();
		return $res;
	}
	/**
	 * 普通账号注册
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	function register($data){
		$data['reg_time']=date('Y-m-d h:i:s',time());
		$data['last_time']=date('Y-m-d h:i:s',time());
		$data['openid']=md5(time().rand(100,999));
		$data['ip']=request()->ip();
		$res=$this->save($data);
		return $res;

	}

	/**
	 * 手机号注册
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	function phoneReg($data){
		$data['state']=1;
		$data['account']=$data['mobile'];
		$data['reg_time']=date('Y-m-d h:i:s',time());
		$data['last_time']=date('Y-m-d h:i:s',time());
		$data['openid']=md5(time().rand(1000,9999));
		$data['ip']=request()->ip();
		$res=$this->save($data);
		return $res;
	}

	/**
	 * 绑定手机
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	function bindPhone($data){
		$user_openid=session('user_openid');
		//执行绑定操作，更新数据库
		$this->where('openid',$user_openid)->update($data);
		//状态值加一
		$res=$this->where('openid',$user_openid)->setInc('state',1);
		return $res;
		
	}

	/**
	 * 绑定邮箱，更新邮箱数据
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	function bindMail($data){
		$user_openid=session('user_openid');
		$res=$this->where('openid',$user_openid)->update($data);
		return $res;
	}

	/**
	 * 邮箱激活链接验证,并激活账户state++
	 * @param  [type] $verify [description]
	 * @return [type]         [description]
	 */
	function mailRegVarity($verify){
		$res=$this->where('openid',$verify)->setInc('state',1);
		return $res;
	}

	/*邮箱注册*/
	function mailReg($data){
		$data['state']=0;
		$data['account']=$data['email'];
		$data['reg_time']=date('Y-m-d h:i:s',time());
		$data['last_time']=date('Y-m-d h:i:s',time());
		$res=$this->save($data);
		return $res;
	}

	/**
	 *1.判断用户是登录还是注册
	 *2.实现用户每次登录，刷新一次信息
	 * @param  [type] $arr [description]
	 * @return [type]      [description]
	 */
	function wxSaveUser($arr){
		$data['wx_openid']=$arr['openid'];
		$data['nickname']=$arr['nickname'];
		$data['sex']=$arr['sex'];
		$data['city']=$arr['city'];
		$data['province']=$arr['province'];
		$data['img_url']=$arr['headimgurl'];
		$data['state']=1;
		$data['last_time']=date('Y-m-d h:i:s',time());
		$data['openid']=md5(time().rand(1000,9999));
		$data['ip']=request()->ip();

		//如果存在用户，者刷新用户信息，否则注册用户信息
		if ($res=$this->where('wx_openid',$arr['openid'])->find()) {
			//微信登录，刷新用户信息
			session('user_openid',$res['openid']);
			session('img_url',$res['img_url']);
			$res=$this->where('openid',$res['openid'])->update($data);
			return $res;
		}else{
			//注册
			$data['reg_time']=date('Y-m-d h:i:s',time());
			$res=$this->save($data);
			return $res;
		}
	}

	/*1.判断用户是登录还是注册
	 *2.实现用户每次登录，刷新一次信息
	 */
	function qqSaveUser($arr){
		//
		$data['state']=1;
		$data['qq_openid']=$arr['openid'];
		$data['nickname']=$arr['info']['nickname'];
		$data['sex']=$arr['info']['gender'];
		$data['province']=$arr['info']['province'];
		$data['city']=$arr['info']['city'];
		$data['img_url']=$arr['info']['figureurl_qq_2'];
		$data['ip']=request()->ip();
		$data['last_time']=date('Y-m-d h:i:s',time());

		//如果存在用户，者刷新用户信息，否则注册用户信息
		if ($res=$this->where('qq_openid',$arr['openid'])->find()) {
			//QQ登录，刷新用户信息
			session('user_openid',$res['openid']);
			session('img_url',$data['img_url']);
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

}