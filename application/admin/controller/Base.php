<?php
namespace app\admin\controller;

use app\common\controller\Base as BaseController;

class Base extends BaseController
{
    final protected function url()
    {
        $path = path();
        return $path['controller'] . '/' . $path['action'];
    }

    protected function jump($url = 'index', $data = [], $msg = '操作成功')
    {
        return $this->success($msg, $url, $data);
    }

    protected function check($msg = true)
    {
        if ($msg !== true) {
            return $this->error($msg ? $msg : '操作失败');
        }
    }

    public function _empty()
    {
        return $this->fetch();
    }
}
