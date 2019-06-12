<?php
namespace app\common\handle;

use Exception;
use think\exception\HttpResponseException;

class Api extends Base
{
    /**
     * http状态码
     * @var unknown
     */
    public $httpCode = 500;

    public function render(Exception $exception)
    {
        return json([
            'code' => max(1, $this->getCode($exception)),
            'msg'  => $this->getMessage($exception),
            'time' => time(),
            'data' => [],
        ], $this->httpCode);
    }
}
