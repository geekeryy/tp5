ThinkPHP 5.0
===============

功能完成情况：
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


 + [文件上传与下载]
 + [信息发布]
 + [地图]
 + [图片识别？]


注；
1.QQ，微信授權登錄時，只獲取數據庫信息，不更新用戶基本信息，微信自動登錄拉取微信最新信息
2.綁定郵箱必須是沒有註冊過的郵箱，如果不存在賬號名，則郵箱作為默認賬號名和密碼
3.綁定手機必須是沒有註冊過的手機，如果不存在賬號名，則手機號作為默認賬號名，驗證碼作為默認密碼
4.手機註冊，郵箱註冊，作為默認賬號
5.绑定QQ、微信只插入对应openid，不更新数据
6.微信QQ首次登录便是注册

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

疑问：
 - validate的length规则怎么用(已解决)
 : 'length:6,10'
 - 模型中如何使用事务
 - ThinkPHP钩子函数？











## 参与开发
请参阅 [ThinkPHP5 核心框架包](https://github.com/top-think/framework)。

## 版权信息

ThinkPHP遵循Apache2开源协议发布，并提供免费使用。

本项目包含的第三方源码和二进制文件之版权信息另行标注。

版权所有Copyright © 2006-2017 by ThinkPHP (http://thinkphp.cn)

All rights reserved。

ThinkPHP® 商标和著作权所有者为上海顶想信息科技有限公司。

更多细节参阅 [LICENSE.txt](LICENSE.txt)
