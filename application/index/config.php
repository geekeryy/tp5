<?php

return [
    // +----------------------------------------------------------------------
    // | QQ登录配置
    // +----------------------------------------------------------------------

    // QQ登录回调域名
    'qq_callback'          => 'http://localhost/thinkphp_5.0.10_full/public/index/oauth/callback.html',
    // 'qq_callback'          => 'http://www.jiangyang.me/index/oauth/callback.html',
    // QQ登录appid
    'qq_appid'             =>'101401381',
    //QQ登录appkey
    'qq_appkey'            =>'1aca1a19c97cb66f2fcbc38120898583',
    //scope
    'qq_scope'             =>'get_user_info',
    //errorReport
    'qq_errorReport'       =>true,
    //storageType
    'qq_storageType'       =>'file',

    //QQ登录成功返回地址
    'callback_url'         =>'http://localhost/thinkphp_5.0.10_full/public/index/index/test2.html',
    // 'callback_url'         =>'http://www.jiangyang.me',
    // +----------------------------------------------------------------------
    // | 云片网短信API
    // +----------------------------------------------------------------------
    'yunpian_apikey'       =>'70777a9cca857a65f0341d6371a7ad29',
    
];
