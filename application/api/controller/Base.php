<?php
namespace app\api\controller;

use app\common\controller\Base as BaseController;

class Base extends BaseController
{
    protected function success($msg = '操作成功', $url = null, $data = '', $wait = 3, array $header = [])
    {
        return $this->result([], 0, $msg);
    }

    protected function error($msg = '操作失败', $url = null, $data = '', $wait = 3, array $header = [])
    {
        return $this->result([], 1, $msg);
    }

    protected function handle(\Exception $e)
    {
        return $this->result([], $e->getCode(), $e->getMessage());
    }

    protected function result($data, $code = 0, $msg = '请求成功', $type = 'json', array $header = [])
    {
        return parent::result($data, $code, $msg, $type, $header);
    }

    public function _empty()
    {
        return $this->result([], 404, '页面不存在');
    }
}
