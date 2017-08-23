<?php
namespace app\admin\controller;
use WxpayAPI\lib\CLogFileHandler;
use WxpayAPI\lib\PayNotifyCallBack;
use WxpayAPI\lib\WxPayUnifiedOrder;
use WxpayAPI\lib\WxPayConfig;
use WxpayAPI\lib\WxPayApi;
use WxpayAPI\lib\Log;
use WxpayAPI\lib\JsApiPay;
use WxpayAPI\lib\WxPayResults;
use WxpayAPI\lib\WxPayException;
class Wxpay extends \think\Controller{

	/**
	 * 用户点击结算下单
	 * @return [type] [description]
	 */
	function order(){

		if (!session('user_openid')) {
			$this->error('请先登录');
		}
		
		//生成订单ID
		$order_id=md5(time().session('user_openid'));

		//获取订单信息
		$input=input('post.');
		$data=array();
		if (isset($input['num']) && !empty($input['num'])) {
			$i=0;
			//校验数据
			$validate=validate('OrderValidate');
			foreach ($input['num'] as $key1 => $value1) {
				$data[$i]['product_id']=$key1;
				$data[$i]['product_num']=$value1;
				$data[$i]['order_id']=$order_id;

				if (!$validate->scene('order')->check($data[$i])) {
					$this->error('数据有误');
				}
				$i++;
			}

		}else{
			$this->error('没有数据');
		}
		//生成body，商品描述
		$body=$i."件商品";
		//计算total_fee
		$product=model('ProductInfo');
		$total_fee=$product->countTotalFee($data);
		if (!$total_fee) {
			$this->error('订单金额有误！','index/index');
		}
		//记录order表
		$order_data['order_id']=$order_id;
		$order_data['user_openid']=session('user_openid');
		$order_data['total_fee']=$total_fee;
		$order_data['body']=$body;
		$order=model('Order');
		if (!$order->saveOrder($order_data)) {
			$this->error('order表写入失败');
		}
		//保存订单信息order_info
		$order=model('OrderInfo');
		if ($order->saveOrderInfo($data)) {
			//订单信息保存成功，调取订单模板
			session('order_id',$order_id);
			session('total_fee',$total_fee);
			$this->redirect('index/wxpay');
		}else{
			//订单保存失败，写入日志
			$this->error('订单保存失败');
		}		
	}

	/**
	 * 微信支付
	 * 生成支付页面
	 * @return [type] [description]
	 */
	function pay(){

		if (!session('order_id')) {
			$this->error('订单已经被取消，请重新下单');
		}
		//获取用户订单信息
		$order=model('Order');
		$res=$order->show(array('order_id'=>session('order_id')));
		
		if (!$res) {
			$this->error('订单数据库查询失败');
		}
		if ($res['state'] && $res['time']) {
			$this->error('订单已支付，请勿重复付款！');
		}
		$data['attach']=$res['order_id'];
		$data['body']=$res['body'];
		$data['total_fee']=$res['total_fee'];

		$logHandler= new CLogFileHandler(config('wxpay_path')."logs/".date('Y-m-d').'.log');
		$log = Log::Init($logHandler, 15);

		//①、获取用户openid
		$tools = new JsApiPay();
		$openId = $tools->GetOpenid();

		//②、统一下单
		$input = new WxPayUnifiedOrder();
		$input->SetBody($data['body']);//商品名
		$input->SetAttach($data['attach']);//最好用来保存商品唯一标识
		$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));//商户订单号
		$input->SetTotal_fee($data['total_fee']);//总费用
		$input->SetTime_start(date("YmdHis"));//开始时间
		$input->SetTime_expire(date("YmdHis", time() + 600));//订单有效期
		$input->SetNotify_url(config('notify_url'));//异步回调
		$input->SetTrade_type("JSAPI");//支付类型，公众号支付
		$input->SetOpenid($openId);
		$order = WxPayApi::unifiedOrder($input);

		//数据库存订单信息
		
		$jsApiParameters = $tools->GetJsApiParameters($order);

		//获取共享收货地址js函数参数
		$editAddress = $tools->GetEditAddressParameters();

		$res=array('jsApiParameters'=>$jsApiParameters,'editAddress'=>$editAddress);

		return $res;
	}

	/**
	 *  异步通知功能
	 * @return [type] [description]
	 */
	function notify(){
		//初始化日志
		$logHandler= new CLogFileHandler(config('wxpay_path')."logs/".date('Y-m-d').'.log');
		$log = Log::Init($logHandler, 15);
		Log::DEBUG("begin notify");
		$notify = new PayNotifyCallBack();
		$notify->Handle(false);
	}
} 