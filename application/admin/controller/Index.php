<?php
namespace app\admin\controller;

/**
* 
*/
class Index extends \think\Controller
{
    
    function index(){
        return view('index/index',['page'=>'index']);
    }
    function form(){
        return view('index/form',['page'=>'form']);
    }
    function tables(){
        return view('index/tables',['page'=>'tables']);
    }
    function notfind(){
        return view('index/notfind',['page'=>'notfind']);
    }
    function calendar(){
        return view('index/calendar',['page'=>'calendar']);
    }
    function chart(){
        return view('index/chart',['page'=>'chart']);
    }
    function login(){
        return view('index/login',['page'=>'login']);
    }
    function signup(){
        return view('index/signup',['page'=>'signup']);
    }
    function tablelistimg(){
        return view('index/tablelistimg',['page'=>'tablelistimg']);
    }
    function tablelist(){

        $data=action('main/studentList');
        return view('index/tablelist',['page'=>'tablelist','list'=>$data['list'],'pn'=>$data['pn'],'total'=>$data['total'],'per'=>$data['per']]);
    }
    function test(){
        return view('index/test',['page'=>'test']);
    }
    function session(){
        var_dump(session(''));
    }
}