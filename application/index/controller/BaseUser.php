<?php
namespace app\index\controller;

use think\facade\Session;
use app\common\service\User;

class BaseUser extends Base
{
    protected $user_id, $user_info;

    protected function initialize()
    {
        parent::initialize();
        $this->checkLogin();
        $this->initUser();
    }

    final private function checkLogin()
    {
        if (!Session::has('user_id')) {
            $this->redirect('auth/index');
        }
    }

    final private function initUser()
    {
        $this->user_id = Session::get('user_id');
        $this->user_info = User::get($this->user_id);
        $this->assign([
            'user_info' => $this->user_info,
        ]);
    }
}
