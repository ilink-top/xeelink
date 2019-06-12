<?php
namespace app\index\controller;

use app\common\controller\Base as BaseController;

class Base extends BaseController
{
    public function _empty()
    {
        $this->error('页面不存在');
    }
}
