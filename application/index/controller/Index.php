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
    	return view('index/test',['name'=>'thinkphp']);
    }
    public function test2()
    {    	
    	return view('index/test2',['name'=>'thinkphp']);
    }
    public function test3()
    {       
        return view('index/test3',['name'=>'thinkphp']);
    }
    public function test4()
    {       
        return view('index/test4',['name'=>'thinkphp']);
    }
}
