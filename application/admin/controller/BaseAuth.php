<?php
namespace app\admin\controller;

class BaseAuth extends BaseLogin
{
    public function __construct()
    {
        parent::__construct();

        // 检查菜单权限
        if (!$this->auth->check($this->url(), $this->user_id)) {
            $this->redirect('index/index');
        }
    }
}
