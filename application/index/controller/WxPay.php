<?php
namespace app\index\controller;
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
	 * 微信支付
	 * 生成订单
	 * @return [type] [description]
	 */
	function pay(){

		// $data['attach']=input('post.attach');
		// $data['body']=input('post.body');
		// $data['total_fee']=input('post.num');
		$data['attach']='123456';
		$data['body']='测试商品';
		$data['total_fee']='1';
		// return var_dump($data);
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
		// $this->redirect('index/wxpay')
		// return view('index/wxpay',['page'=>'wxpay','jsApiParameters'=>$res['jsApiParameters'],'editAddress'=>$res['editAddress']]);

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