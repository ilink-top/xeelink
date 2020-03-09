<?php
namespace app\controller;

use app\library\ErrorCode;
use think\exception\HttpResponseException;
use think\Response;

class ApiController extends Controller
{
    /**
     * @inheritdoc
     */
    protected function success($msg = 'ok', $url = null, $data = [], $wait = 3, array $header = [])
    {
        return $this->result($data, ErrorCode::OK, $msg, 'json', $header);
    }

    /**
     * @inheritdoc
     */
    protected function error($msg = '操作失败', $url = null, $data = [], $wait = 3, array $header = [])
    {
        return $this->result($data, ErrorCode::ERROR, $msg, 'json', $header);
    }

    /**
     * @inheritdoc
     */
    protected function result($data, $code = ErrorCode::OK, $msg = 'ok', $type = 'json', array $header = [])
    {
        return api_result($code, $msg, $data, $header);
    }
}
