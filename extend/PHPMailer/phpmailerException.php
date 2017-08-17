<?php
/**
 * PHPMailer exception handler
 * @package PHPMailer
 */
namespace PHPMailer;
class phpmailerException extends \think\Exception
{
    /**
     * Prettify error message output
     * @return string
     */
    public function errorMessage()
    {
        $errorMsg = '<strong>' . htmlspecialchars($this->getMessage()) . "</strong><br />\n";
        return $errorMsg;
    }
}
