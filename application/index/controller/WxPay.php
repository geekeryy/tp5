<?php
namespace app\index\controller;
use WxpayAPI\example\CLogFileHandler;
use WxpayAPI\example\PayNotifyCallBack;
use WxpayAPI\example\WxPayUnifiedOrder;
use WxpayAPI\example\WxPayConfig;
use WxpayAPI\example\WxPayApi;
use WxpayAPI\example\Log;
use WxpayAPI\example\JsApiPay;
use WxpayAPI\example\WxPayResults;
class Wxpay extends \think\Controller{
	/**
	 * 微信支付
	 * @return [type] [description]
	 */
	function pay(){
		$logHandler= new CLogFileHandler(config('wxpay_path')."logs/".date('Y-m-d').'.log');
		$log = Log::Init($logHandler, 15);

		//①、获取用户openid
		$tools = new JsApiPay();
		$openId = $tools->GetOpenid();

		//②、统一下单
		$input = new WxPayUnifiedOrder();
		$input->SetBody("testBody");
		$input->SetAttach("miaoshu");
		$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));//商户订单号
		//费用
		$input->SetTotal_fee("1");
		$input->SetTime_start(date("YmdHis"));//开始时间
		$input->SetTime_expire(date("YmdHis", time() + 600));//订单有效期
		$input->SetGoods_tag("test");//商品标记
		$input->SetNotify_url("http://www.jiangyang.me/index/Wxpay/notify");//异步回调
		$input->SetTrade_type("JSAPI");//支付类型，公众号支付
		$input->SetOpenid($openId);
		$order = WxPayApi::unifiedOrder($input);
		// echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
		// printf_info($order);
		session('xiadan',$order);
		$jsApiParameters = $tools->GetJsApiParameters($order);

		//获取共享收货地址js函数参数
		$editAddress = $tools->GetEditAddressParameters();

		$arr=array('jsApiParameters'=>$jsApiParameters,'editAddress'=>$editAddress);
		session('1',$arr);
		return $arr;
	}
	/**
	 *  异步通知功能
	 * @return [type] [description]
	 */
	function notify(){



		if ($xmldata=file_get_contents("php://input")) {

				$data=json_decode(json_encode(simplexml_load_string($xmldata, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
				
			    $payinfo=model('PayInfo');
	            $payinfo->savePayinfo($data);
	            return "SUCCESS";
			}else{
				$test=model('Test');
	            $test->test(array('state'=>0,'tag'=>'没有读取数据','time'=>date('Y-m-d h:i:s',time())));
			}
// {"appid":"wxba7464d31a8fd9b9","attach":"miaoshu","bank_type":"CFT","cash_fee":"1","fee_type":"CNY","is_subscribe":"Y","mch_id":"1406572302","nonce_str":"c9bitdpl1l7ufcf4vtede9s53lfu8i5u","openid":"o-n76wB3d8kW6jA-sWNOZCEEdxaQ","out_trade_no":"140657230220170812212852","result_code":"SUCCESS","return_code":"SUCCESS","sign":"5E3C7834DC8567ABDE0B4785DD148F35","time_end":"20170812212858","total_fee":"1","trade_type":"JSAPI","transaction_id":"4008082001201708125903724215"}


		//初始化日志
		$logHandler= new CLogFileHandler(config('wxpay_path')."logs/".date('Y-m-d').'.log');
		$log = Log::Init($logHandler, 15);
		Log::DEBUG("begin notify");
		$notify = new PayNotifyCallBack();
		$notify->Handle(false);
	}
} 