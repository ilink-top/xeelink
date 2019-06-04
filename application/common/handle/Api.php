<?php
namespace app\common\handle;

use Exception;

class Api extends Base
{
    /**
     * http状态码
     * @var unknown
     */
    public $httpCode = 500;

    public function render(Exception $exception)
    {
        $code = $this->getCode($exception);
        $code = max($code, 1);
        $msg = $this->getMessage($exception);
        $apiData = apiReturn($msg, $code, []);
        return json($apiData, $this->httpCode);
    }
}
