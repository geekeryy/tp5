<?php
namespace app\index\validate;

/**
* 订单验证器
*/
class OrderValidate extends \think\Validate
{

	protected $rule = [
		'product_id'=>['require'],
		'product_num'=>['require','number'],
		'order_id'=>['require'],
	];

	protected $message = [
		'product_num.require'=>'数量必须填写',
	];

	protected $scene = [
		'order'=>'product_id,product_num,order_id',

	];
	
}