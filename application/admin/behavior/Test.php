<?php
namespace app\index\behavior;
class Test{
	function run(&$params){
		$test=new \app\index\model\Test();
		$test->test($params);
		return 'ok';
		// echo "behavior";
		// exit();
		// $test=$model("Test");
		// $test->test(array('states'=>9,'tag'=>'behavior'));
	}
}