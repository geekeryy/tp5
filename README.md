ThinkPHP 5.0
===============


教务管理系统
 + [学生课表查询]
 + [学生成绩查询]
 + [学生成绩统计]
 + [学生学号分析]
 + [等级考试成绩查询]

1.geiViewState函数待优化
2.首次使用保存相关信息，暂时不支持更新

admin功能完成情况
 + [用户账号管理]
 + [访问记录查询]
 + [用户订单查询]
 + [支付信息详情]
 + 
 注：
1.admin为pc端









index功能完成情况：
 + [普通账号注册](http://www.jiangyang.me/index/index/register)
 + [邮箱注册](http://www.jiangyang.me/index/index/mailreg)
   默认账号名为邮箱，验证码是用户的openid(需改进)
 + [手机号注册](http://www.jiangyang.me/index/index/phonereg)
   默认账号名为手机


 + [普通账号登录](http://www.jiangyang.me/index/User/login)
   账号可以是邮箱、手机号(需绑定,还未完成)
 + [手机快捷登录](http://www.jiangyang.me/index/User/phonelogin)
   填写手机，发送短信验证码
 + [微信授权登录](http://www.jiangyang.me/index/Oauth/wxLogin)
   注册时将用户信息写入数据库，授权登录时不更新基本信息
 + [微信静默登录](http://www.jiangyang.me/index/Oauth/wxAutoLogin)
   如果是微信浏览器，则通过获取wx_openid，换取用户信息，不更新数据库
 + [QQ快捷登录](http://www.jiangyang.me/index/Oauth/qq_login)
   注册时将用户信息写入数据库，授权登录时不更新基本信息


 + [绑定邮箱](http://www.jiangyang.me/index/index/bindmail) 
   需要用户登录，一个邮箱仅允许绑定一个账号
   验证码是用户的openid(需改进)
 + [绑定手机](http://www.jiangyang.me/index/index/bindphone)
   需要用户登录，一个手机仅允许绑定一个账号
 + [绑定微信](http://www.jiangyang.me/index/Oauth/bindWX) 
   需要用户登录，一个微信仅允许绑定一个账号
   验证码是用户的openid(需改进)
 + [绑定QQ](http://www.jiangyang.me/index/Oauth/bindQQ)
   需要用户登录，一个QQ仅允许绑定一个账号


 + [微信JSSDK](http://www.jiangyang.me/index/index/wxjssdk)

 + [微信支付](http://www.jiangyang.me/index/index/wxpay)
   发起支付，订单详情，

 + [文件上传与下载]
 + [信息发布]
 + [地图,地理位置]
 + [图片识别]
 + [session,input数据加密]
 + [表单令牌]


注；
1.QQ，微信授權登錄時，只獲取數據庫信息，不更新用戶基本信息
2.微信QQ首次登录便是注册，注册后再次登录不改变用户信息
3.綁定手機必須是沒有註冊過的手機，如果不存在賬號名，則手機號作為默認賬號名，驗證碼作為默認密碼
4.綁定郵箱必須是沒有註冊過的郵箱，如果不存在賬號名，則郵箱作為默認賬號名和密碼
5.绑定QQ、微信只插入对应openid，不更新数据
6.手機註冊，郵箱註冊，作為默認賬號

 用户注册方式
 + 普通账号注册，status=0
 + 邮箱注册
 + 手机注册
 + QQ注册
 + 微信注册

 用户登录方式
 + 普通账号，密码登录(賬號可以是手機郵箱，前提是先綁定)
 + QQ快捷登录
 + 手机，验证码登录
 + 微信快捷授权登录
 + 微信自動登錄(前提是微信註冊，或者微信綁定用戶)

 微信支付
 + 保存用户支付相关信息
 + 保存信息失败写入日志

疑问：
 - validate的length规则怎么用？
 : 'length:6,10'
 - 模型中如何使用事务？
 - ThinkPHP钩子函数？
 : 已学习
 - 微信QQ账号分别被注册，需要绑定在一起怎么办？











## 参与开发
请参阅 [ThinkPHP5 核心框架包](https://github.com/top-think/framework)。

## 版权信息

ThinkPHP遵循Apache2开源协议发布，并提供免费使用。

本项目包含的第三方源码和二进制文件之版权信息另行标注。

版权所有Copyright © 2006-2017 by ThinkPHP (http://thinkphp.cn)

All rights reserved。

ThinkPHP® 商标和著作权所有者为上海顶想信息科技有限公司。

更多细节参阅 [LICENSE.txt](LICENSE.txt)
