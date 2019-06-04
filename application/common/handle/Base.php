<?php
namespace app\common\handle;

use Exception;
use think\exception\Handle;
use app\common\exception\ModelException;

class Base extends Handle
{
    protected function getMessage(Exception $exception)
    {
        $message = parent::getMessage($exception);
        if (($exception instanceof ModelException) == false && config('app_debug') == false) {
            $message = '操作失败';
        }
        return $message;
    }
}
