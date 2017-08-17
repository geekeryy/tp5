<?php
/* PHP SDK
 * @version 2.0.0
 * @author connect@qq.com
 * @copyright © 2013, Tencent Corporation. All rights reserved.
 */
namespace QQ_Login_Api\myclass;
use QQ_Login_Api\myclass\ErrorCase;
// require_once(CLASS_PATH."ErrorCase.class.php");
class Recorder{
    private static $data;
    private $inc;
    private $error;

    public function __construct(){
        $this->error = new ErrorCase();
        //-------读取配置文件
         $incFileContents = '{"appid":"'.config('qq_appid').'","appkey":"'.config('qq_appkey').'","callback":"'.config('qq_callback').'","scope":"'.config('qq_scope').'","errorReport":true,"storageType":"'.config('qq_storageType').'"}';

        //$incFileContents = '{"appid":"101401381","appkey":"1aca1a19c97cb66f2fcbc38120898583","callback":"http://www.jiangyang.me/Connect2.1/oauth/callback.php","scope":"get_user_info","errorReport":true,"storageType":"file"}';

        $this->inc = json_decode($incFileContents);

        if(empty($this->inc)){
            $this->error->showError("20001");
        }

        if(empty($_SESSION['QC_userData'])){
            self::$data = array();
        }else{
            self::$data = $_SESSION['QC_userData'];
        }
    }

    public function write($name,$value){
        self::$data[$name] = $value;
    }

    public function read($name){
        if(empty(self::$data[$name])){
            return null;
        }else{
            return self::$data[$name];
        }
    }

    public function readInc($name){
        if(empty($this->inc->$name)){
            return null;
        }else{
            return $this->inc->$name;
        }
    }

    public function delete($name){
        unset(self::$data[$name]);
    }

    function __destruct(){
        $_SESSION['QC_userData'] = self::$data;
    }
}
