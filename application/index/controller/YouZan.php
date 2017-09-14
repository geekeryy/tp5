<?php
namespace app\index\controller;
use YouZan\YZTokenClient;
class YouZan extends \think\Controller{


	function updateSalesman(){
		//
	}

	/**
	 * 更新交易信息
	 * @return [type] [description]
	 */
	function updateTradesInfo(){
		$token = 'e8ccb95e7cf43168b41243975069dc36';//请填入商家授权后获取的access_token
		$client = new YZTokenClient($token);

		$method = 'youzan.salesman.trades.get'; //要调用的api名称
		$api_version = '3.0.0'; //要调用的api版本号

		$my_params = [
		    'start_time' => '0',
		    'page_size' => '1',
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

						$trades_info['seller']=$value['seller'];
						$trades_info['order_no']=$value['order_no'];
						$trades_info['phone']=$value['phone'];
						$trades_info['cps_money']=$value['cps_money'];
						$trades_info['money']=$value['money'];
						$trades_info['created_at']=$value['created_at'];
						$trades_info['state']=$value['state'];

						$info=model('TradesInfo');
						$info->saveTradesInfo($trades_info);

						$i=0;
						foreach ($value['items'] as $key => $value1) {
							$trades_items[$i]=$value1;
							$trades_items[$i]['order_no']=$value['order_no'];
							$i++;
						}
						$items=model('TradesItems');
						$items->saveInfo($trades_items);
					}

					// var_dump($trades_info);
					// var_dump($trades_items);
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
	 * 获取所有交易信息
	 * @return [type] [description]
	 */
	function getAllTrades(){
		$token = 'e8ccb95e7cf43168b41243975069dc36';//请填入商家授权后获取的access_token
		$client = new YZTokenClient($token);

		$method = 'youzan.salesman.trades.get'; //要调用的api名称
		$api_version = '3.0.0'; //要调用的api版本号

		$my_params = [
		    'start_time' => '0',
		    'page_size' => '1',
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
					$info=model('TradesInfo');
					$items=model('TradesItems');
					foreach ($arr['response']['trades'] as $key => $value) {

						$trades_info['seller']=$value['seller'];
						$trades_info['order_no']=$value['order_no'];
						$trades_info['phone']=$value['phone'];
						$trades_info['cps_money']=$value['cps_money'];
						$trades_info['money']=$value['money'];
						$trades_info['created_at']=$value['created_at'];
						$trades_info['state']=$value['state'];
// var_dump($trades_info);
// exit();
						
						$info->saveTradesInfo($trades_info);

						$i=0;
						foreach ($value['items'] as $key => $value1) {
							$trades_items[$i]=$value1;
							$trades_items[$i]['order_no']=$value['order_no'];
							$i++;
						}
						
						$items->saveInfo($trades_items);
					}

					// var_dump($trades_info);
					// var_dump($trades_items);
				}else{
					echo 'null'.$my_params['mobile'].'<br>';
				}
			}else{
				var_dump($arr['error_response']);
				echo 'error'.$my_params['mobile'];
			}
		}


		// foreach ($arr['response']['trades'] as $key => $value) {
		// 	if (!empty($value['items']['1'])) {
		// 		var_dump($value['items']['1']);
		// 	}
		// 	# code...
		// }

	}

	/**
	 * 获取所有销售员账号信息
	 * 用户名使用base64加密
	 * @return [type] [description]
	 */
	function getAllSalesman(){
		$token = 'e8ccb95e7cf43168b41243975069dc36';//请填入商家授权后获取的access_token
		$client = new YZTokenClient($token);

		$method = 'youzan.salesman.accounts.get'; //要调用的api名称
		$api_version = '3.0.0'; //要调用的api版本号


		// $my_params = [
		//     'page_no' => '1',
		//     'page_size' => '100',
		// ];
		$arr=$client->post($method, $api_version, $my_params);
// var_dump($arr);
		foreach ($arr['response']['accounts'] as $key => $value) {
			$arr['response']['accounts'][$key]['nickname']=base64_encode($value['nickname']);
		}
// var_dump($arr);
		// foreach ($arr['response']['accounts'] as $key => $value) {
		// 			$arr['response']['accounts'][$key]['nickname']=base64_decode($value['nickname']);
		// 		}
// return var_dump($arr);exit();
		$salesman_account=model('SalesmanAccounts');
		$res=$salesman_account->saveSalesmanAccount($arr);	

		// $my_files = [
		// ];
		// echo '<pre>';
		// var_dump(
		    // $client->post($method, $api_version, $my_params)
		// );
		// echo '</pre>';
	}
}