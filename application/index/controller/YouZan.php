<?php
namespace app\index\controller;
use YouZan\YZTokenClient;
use YouZan\YZGetTokenClient;
/**
 * 1.日志
 * 2.异常
 * 3.登录
 * 4.自动更新
 * 5.推送
 */
class YouZan extends \think\Controller{

	/**
	 * 获取有赞云的推送消息
	 * @return [type] [description]
	 */
	function messagePush(){
		$client_id = config('youzan_config.client_id');//请填入有赞云控制台的应用client_id
		$client_secret = config('youzan_config.client_secret');//请填入有赞云控制台的应用client_secret

		$json = file_get_contents('php://input'); 
		$data = json_decode($json, true);

		/**
		 * 判断消息是否合法，若合法则返回成功标识
		 */
		$msg = $data['msg'];
		$sign_string = $client_id."".$msg."".$client_secret;
		$sign = md5($sign_string);
		if($sign != $data['sign']){
		    exit();
		}else{
		    $result = array("code"=>0,"msg"=>"success") ;
		    var_dump($result);
		}

		/**
		 * msg内容经过 urlencode 编码，需进行解码
		 */
		$msg = json_decode(urldecode($msg),true);

		/**
		 * 根据 type 来识别消息事件类型，具体的 type 值以文档为准，此处仅是示例
		 */
		if($data['type'] == "TRADE_ORDER_STATE"){
		    $message=model('MessagePush');
		    $message->saveMessage($data);
		}
		return $result;
	}

	/**
	 * 获取access_token
	 * @return [type] [description]
	 */
	function getToken(){
		$client_id = config('youzan_config.client_id');//请填入有赞云控制台的应用client_id
		$client_secret = config('youzan_config.client_secret');//请填入有赞云控制台的应用client_secret
		$keys['kdt_id'] = config('youzan_config.kdt_id');
		$type = 'self';

		$access=model('AccessToken');

		if (!$res=$access->getAccessToken()) {
			$token = new YZGetTokenClient( $client_id , $client_secret );
			$access_token=$token->get_token( $type , $keys );
			$access->saveAccessToken($access_token['access_token']);
		}else{
			$access_token['access_token']=$res['access_token'];
		}
		return $access_token['access_token'];

	}

	/**
	 * 获取团队所有成员信息
	 * @param  [type] $team_id [description]
	 * @return [type]          [description]
	 */
	function getTeamMember($team_id){
		$team['team_id']=$team_id;
		$salesman=model('SalesmanAccounts');
		$list=$salesman->getSalesman($team);
		
		foreach ($list as $key => $value) {
			$list[$key]['nickname']=base64_decode($value['nickname']);
		}
		echo $team_id.'团队的所有成员：<br>';
		return var_dump($list);
	}

	/**
	 * 获取个人月/日销售额
	 * 参数phone,time
	 * @return [type] [description]
	 */
	function getPerSales($phone,$time){
		// $where['phone']='15282868308';
		$where['phone']=$phone;
		$where['time']=$time;
		$trades_info=model('TradesInfo');
		$person=$trades_info->getSales($where);
		$money=0;
		foreach ($person as $key => $value) {
			$money+=(float)$value['money'];
		}

		if ($time=='day') {
			$word='日';
		}else{
			$word='月';
		}
		echo $where['phone'].'的'.$word.'销售量为：'.$money;
		echo '<br>';
		
	}

	/**
	 * 获取团队月/日销售额
	 * 参数team_id,time
	 * @return [type] [description]
	 */
	function getTeamSales($team_id,$time){
		$team['team_id']=$team_id;
		$salesman=model('SalesmanAccounts');
		$list=$salesman->getSalesman($team);
		
		$where['time']=$time;
		$money=0;
		$phone=array();

		//获取团队所有成员的mobile
		foreach ($list as $key => $value) {
			$phone[]=$value['mobile'];
		}

		//查询团队指定时间段所有人的销量
		$where['phone']=$phone;
		$trades_info=model('TradesInfo');
		$person=$trades_info->getSales($where);
		foreach ($person as $key => $value) {
			$money+=(float)$value['money'];
		}

		if ($time=='day') {
			$word='日';
		}else{
			$word='月';
		}

		echo $team['team_id'].'的团队'.$word.'销量为：'.$money;
		echo '<br>';
		// var_dump($info);
		// echo  $money;
	}

	/**
	 * 获取个人累计销量
	 * @return [type] [description]
	 */
	function getPerCumulativeSales($mobile){
		$where['mobile']=$mobile;
		$salesman=model('SalesmanAccounts');
		$list=$salesman->getPerCumulativeSales($where);
		echo $where['mobile'].'的累计销量'.$list['money'];
		echo '<br>';
	}

	/**
	 * 获取团队累计销量
	 * @return [type] [description]
	 */
	function getTeamCumulativeSales($team_id){
		$where['team_id']=$team_id;
		$salesman=model('SalesmanAccounts');
		$list=$salesman->getTeamCumulativeSales($where);
		$count=0;
		foreach ($list as $key => $value) {
			$count+=(float)$value['money'];
		}
		echo $where['team_id'].'团队累计销量为：';
		echo $count;
		echo '<br>';
	}


	/**
	 * 获取信息
	 * @return [type] [description]
	 */
	function getTeamer(){
		action('YouZan/getPerCumulativeSales',['mobile'=>'18011600166']);
		action('YouZan/getTeamCumulativeSales',['team_id'=>'1001']);
		action('YouZan/getPerSales',['phone'=>'18011600166','time'=>'month']);
		action('YouZan/getTeamSales',['team_id'=>'1001','time'=>'month']);
		action('YouZan/getPerSales',['phone'=>'18011600166','time'=>'day']);
		action('YouZan/getTeamSales',['team_id'=>'1001','time'=>'day']);
		action('YouZan/getTeamMember',['team_id'=>'1000']);
	}

	/**
	 * 更新指定销售员交易信息
	 * 消息推送时使用，3
	 * @return [type] [description]
	 */
	function updatePerTradesInfo($mobile){
		$token=action('YouZan/getToken');
		$client = new YZTokenClient($token);

		$method = 'youzan.salesman.trades.get'; //要调用的api名称
		$api_version = '3.0.0'; //要调用的api版本号

		$my_params = [
		    'start_time' => '0',
		    'page_size' => '100',
		    'page_no' => '1',
		    'mobile' => $mobile,
		    'fans_type' => '1',
		    'fans_id' => '1',
		    'end_time' => '0',
		];

		$my_files = [
		];
			$arr=$client->post($method, $api_version, $my_params, $my_files);
			if (!isset($arr['error_response'])) {
				if ($arr['response']['total_results']) {
					foreach ($arr['response']['trades'] as $key => $value) {
						$info=model('TradesInfo');
						$info->saveTradesInfo($value);
						$i=0;
						foreach ($value['items'] as $key => $value1) {
							$trades_items[$i]=$value1;
							$trades_items[$i]['order_no']=$value['order_no'];
							$i++;
						}
						$items=model('TradesItems');
						$items->saveInfo($trades_items);
					}
				}else{
					echo 'null'.$my_params['mobile'].'<br>';
				}
			}else{
				var_dump($arr['error_response']);
				echo 'error'.$my_params['mobile'];
			}
	}


	/**
	 * 更新交易信息
	 * @return [type] [description]
	 */
	function updateTradesInfo(){
		$token=action('YouZan/getToken');
		$client = new YZTokenClient($token);

		$method = 'youzan.salesman.trades.get'; //要调用的api名称
		$api_version = '3.0.0'; //要调用的api版本号

		$my_params = [
		    'start_time' => '0',
		    'page_size' => '100',
		    'page_no' => '1',
		    'mobile' => '18095040373',
		    'fans_type' => '1',
		    'fans_id' => '1',
		    'end_time' => '0',
		];

		$my_files = [
		];

		$salesman=model('SalesmanAccounts');
		$list=$salesman->getAllSalesman();
		$list=json_decode(json_encode($list),true);

		foreach ($list as $key => $mobile) {
			$my_params['mobile']=$mobile['mobile'];
			$arr=$client->post($method, $api_version, $my_params, $my_files);
			//销售量不能为0
			//{"error_response":{"code":140400200,"message":"user not exist"}}
			if (!isset($arr['error_response'])) {

				if ($arr['response']['total_results']) {
					
					foreach ($arr['response']['trades'] as $key => $value) {

						// $trades_info['seller']=$value['seller'];
						// $trades_info['order_no']=$value['order_no'];
						// $trades_info['phone']=$value['phone'];
						// $trades_info['cps_money']=$value['cps_money'];
						// $trades_info['money']=$value['money'];
						// $trades_info['created_at']=$value['created_at'];
						// $trades_info['state']=$value['state'];

						$info=model('TradesInfo');
						$info->saveTradesInfo($value);

						$i=0;
						foreach ($value['items'] as $key => $value1) {
							$trades_items[$i]=$value1;
							$trades_items[$i]['order_no']=$value['order_no'];
							$i++;
						}
						$items=model('TradesItems');
						$items->saveInfo($trades_items);
					}
				}else{
					echo 'null'.$my_params['mobile'].'<br>';
				}
			}else{
				var_dump($arr['error_response']);
				echo 'error'.$my_params['mobile'];
			}
		}
		
	}


	/**
	 * 更新所有销售员账号信息
	 * 用户名使用base64加密
	 * 只更新前100条数据
	 * @return [type] [description]
	 */
	function updateSalesman(){
		$token=action('YouZan/getToken');
		$client = new YZTokenClient($token);

		$method = 'youzan.salesman.accounts.get'; //要调用的api名称
		$api_version = '3.0.0'; //要调用的api版本号

		$my_params = [
		    'page_no' => '1',
		    'page_size' => '100',
		];
		$arr=$client->post($method, $api_version, $my_params);
		if (!isset($arr['error_response'])) {
			foreach ($arr['response']['accounts'] as $key => $value) {
				$arr['response']['accounts'][$key]['nickname']=base64_encode($value['nickname']);
			}

			$salesman_account=model('SalesmanAccounts');
			$res=$salesman_account->updateSalesmanAccount($arr['response']['accounts']);
		}else{
			var_dump($arr['error_response']);
			echo 'error'.$my_params['mobile'];
		}
	}
}