<?php
namespace app\index\controller;

class Index extends \think\Controller
{
    public function index()
    {    	
    	return view('index/index',['page'=>'index']);
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
    public function register()
    {       
        return view('index/register',['page'=>'register']);
    }
    public function bindphone()
    {       
        return view('index/bindphone',['page'=>'bindphone']);
    }
}
