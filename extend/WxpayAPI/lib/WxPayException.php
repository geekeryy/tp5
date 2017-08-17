<?php
/**
 * 
 * 微信支付API异常类
 * @author widyhu
 *
 */
namespace WxpayAPI\lib;
use \think\Exception;
class WxPayException extends Exception {
	public function errorMessage()
	{
		return $this->getMessage();
	}
}
