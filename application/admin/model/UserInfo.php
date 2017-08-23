<?php
namespace app\admin\model;

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
	/**
	 * 更新登录信息
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
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
		if ($res) {
			session('user_openid',$res['openid']);
			$arr['ip']=request()->ip();
			$arr['last_time']=date('Y-m-d h:i:s',time());
			$this->where($data)->update($arr);
		}
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
	function bindPhone($arr){
		$user_openid=session('user_openid');
		$data['mobile']=$arr['mobile'];
		//如果不存在賬號名，則手機號作為默認賬號名，驗證碼作為默認密碼
		if ($res=$this->where('openid',$user_openid)->find()) {
			if (!$res['account']) {
				$data['account']=$arr['mobile'];
				$data['password']=$arr['code'];
			}
		}
		$this->startTrans();
		//执行绑定操作，更新数据库
		if (!$this->where('openid',$user_openid)->update($data) || !$this->where('openid',$user_openid)->setInc('state',1)) {
			$this->rollback();
			return false;
		}
		$this->commit();
		return true;
		
	}

	/**
	 * 绑定邮箱，更新邮箱数据
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	function bindMail($data){
		$user_openid=session('user_openid');
		//如果不存在賬號名，則郵箱作為默認賬號名和密碼
		if ($res=$this->where('openid',$user_openid)->find()) {
			if (!$res['account']) {
				$data['account']=$data['email'];
				$data['password']=$data['email'];
			}
		}
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

	/**
	 * 邮箱注册
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	function mailReg($data){
		$data['state']=0;
		$data['account']=$data['email'];
		$data['reg_time']=date('Y-m-d h:i:s',time());
		$data['last_time']=date('Y-m-d h:i:s',time());
		$res=$this->save($data);
		return $res;
	}

	/**
	 * 綁定微信
	 * @return [type] [description]
	 */
	function bindWX($data){
		$user_openid=session('user_openid');
		$res=$this->where('openid',$user_openid)->update($data);
		$res=$this->where('openid',$user_openid)->setInc('state',1);			
		return $res;
	}
	/**
	 * 判断用户是登录还是注册
	 * @param  [type] $arr [description]
	 * @return [type]      [description]
	 */
	function wxSaveUser($arr){
		$data['last_time']=date('Y-m-d h:i:s',time());
		$data['ip']=request()->ip();

		//如果存在用户，则为登录，刷新用户信息，否则注册用户信息
		if ($res=$this->where('wx_openid',$arr['openid'])->find()) {
			//微信登录，刷新用户数据
			$res=$this->where('openid',$res['openid'])->update($data);
			return $res;
		}else{
			//微信注册，注册后再次授权登录将不改变用户信息
			$data['nickname']=$arr['nickname'];
			$data['sex']=$arr['sex'];
			$data['city']=$arr['city'];
			$data['province']=$arr['province'];
			$data['img_url']=$arr['headimgurl'];
			$data['wx_openid']=$arr['openid'];
			$data['state']=1;
			$data['openid']=md5(time().rand(1000,9999));
			$data['reg_time']=date('Y-m-d h:i:s',time());
			$res=$this->save($data);
			return $res;
		}
	}

	/**
	 * 綁定QQ
	 * @return [type] [description]
	 */
	function bindQQ($data){
		$user_openid=session('user_openid');
		$res=$this->where('openid',$user_openid)->update($data);
		$res=$this->where('openid',$user_openid)->setInc('state',1);
		return $res;
	}

	/**
	 * 判断用户是登录还是注册
	 * @param  [type] $arr [description]
	 * @return [type]      [description]
	 */
	function qqSaveUser($arr){
		$data['ip']=request()->ip();
		$data['last_time']=date('Y-m-d h:i:s',time());

		//不管登录注册都会存储头像信息
		session('img_url',$arr['info']['figureurl_qq_2']);

		//如果存在用户，者刷新用户信息，否则注册用户信息
		if ($res=$this->where('qq_openid',$arr['openid'])->find()) {
			//QQ登录，刷新用户信息
			//登录则在数据库取user_openid
			session('user_openid',$res['openid']);

			$res=$this->where('openid',$res['openid'])->update($data);
			return $res;
		}else{
			//注册
			$data['nickname']=$arr['info']['nickname'];
			$data['sex']=$arr['info']['gender'];
			$data['province']=$arr['info']['province'];
			$data['city']=$arr['info']['city'];
			$data['img_url']=$arr['info']['figureurl_qq_2'];
			$data['openid']=md5(time().rand(1000,9999));
			$data['state']=1;
			$data['qq_openid']=$arr['openid'];
			$data['reg_time']=date('Y-m-d h:i:s',time());
			//注册则创建user_openid并存储
			session('user_openid',$data['openid']);

			//执行save多个的时候，只执行最后一条
			$res=$this->save($data);
			return $res;
		}
	}

}