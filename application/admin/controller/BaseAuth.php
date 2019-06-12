<?php
namespace app\admin\controller;

class BaseAuth extends BaseLogin
{
    public function __construct()
    {
        parent::__construct();
        $this->checkAuth();
    }

    final private function checkAuth()
    {
        if (!$this->auth->check($this->url(), $this->user_id)) {
            $this->redirect('index/index');
        }
    }
}
