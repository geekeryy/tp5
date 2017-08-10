ThinkPHP 5.0
===============

功能完成情况：
 + [普通账号注册](http://www.jiangyang.me/index/register)
 + [邮箱注册](http://www.jiangyang.me/index/mailreg)
   默认账号名为邮箱，验证码是用户的openid(需改进)
 + [手机号注册](http://www.jiangyang.me/index/phonereg)
   默认账号名为手机

 + [普通账号登录](http://www.jiangyang.me/User/login)
   账号可以是邮箱、手机号(需绑定,还未完成)
 + [手机快捷登录](http://www.jiangyang.me/User/phonelogin)
   填写手机，发送短信验证码
 + [微信授权登录](http://www.jiangyang.me/Oauth/wxLogin)
 + [QQ快捷登录](http://www.jiangyang.me/Oauth/qq_login)


 + [绑定邮箱](http://www.jiangyang.me/index/bindmail) 
   需要用户登录，一个邮箱仅允许绑定一个账号
   验证码是用户的openid(需改进)
 + [绑定手机](http://www.jiangyang.me/index/bindphone)
   需要用户登录，一个手机仅允许绑定一个账号
 + [微信JSSDK](http://www.jiangyang.me/index/wxjssdk)
 + [文件上传与下载]
 + [信息发布]
 + [地图]


用户注册方式
 + 普通账号注册，status=0
 + 邮箱注册
 + 手机注册
 + QQ注册
 + 微信注册
用户登录方式
 + 普通账号，密码登录
 + QQ快捷登录
 + 手机，验证码登录
 + 手机，密码登录(需要补充密码信息)
 + 邮箱，验证码登录
 + 邮箱，密码登录(需要补充密码信息)
 + 微信快捷授权登录

疑问：
 - validate的length规则怎么用(已解决)
 : 'length:6,10'
 - 模型中如何使用事物











## 参与开发
请参阅 [ThinkPHP5 核心框架包](https://github.com/top-think/framework)。

## 版权信息

ThinkPHP遵循Apache2开源协议发布，并提供免费使用。

本项目包含的第三方源码和二进制文件之版权信息另行标注。

版权所有Copyright © 2006-2017 by ThinkPHP (http://thinkphp.cn)

All rights reserved。

ThinkPHP® 商标和著作权所有者为上海顶想信息科技有限公司。

更多细节参阅 [LICENSE.txt](LICENSE.txt)
