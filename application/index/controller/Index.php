<?php
namespace app\index\controller;

class Index extends \think\Controller
{
    public function index()
    {
        $count=model('Count');
        $data=$count->getCount();
        $ip=request()->ip();
    	return view('index/index',['page'=>'index','count'=>$data,'ip'=>$ip]);
    }
    public function about()
    {    	
    	return view('index/about',['page'=>'about']);
    }
    public function single()
    {    	
    	return view('index/single',['page'=>'single']);
    }
    public function portfolio()
    {    	
    	return view('index/portfolio',['page'=>'portfolio']);
    }
    public function contact()
    {    	
    	return view('index/contact',['page'=>'contact']);
    }
    public function test()
    {    	
    	return view('index/test',['page'=>'test']);
    }
    public function test2()
    {    	
    	return view('index/test2',['page'=>'test2']);
    }
    public function login()
    {       
        return view('index/login',['page'=>'login']);
    }
    public function bindphone()
    {       
        return view('index/bindphone',['page'=>'bindphone']);
    }
    public function bindmail()
    {       
        return view('index/bindmail',['page'=>'bindmail']);
    }
    public function wait()
    {       
        return view('index/wait',['page'=>'wait']);
    }
    public function phonereg()
    {       
        return view('index/phonereg',['page'=>'phonereg']);
    }
    public function mailreg()
    {       
        return view('index/mailreg',['page'=>'mailreg']);
    }
    public function register()
    {       
        return view('index/register',['page'=>'register']);
    }

}
