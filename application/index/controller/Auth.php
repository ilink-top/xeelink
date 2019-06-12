<?php
namespace app\index\controller;

use app\common\service\User;
use think\facade\Session;

class Auth extends Base
{
    public function index()
    {
        return '请登录';
    }

    public function login()
    {
        $param = $this->request->param();
        $user = User::login($param['username'], $param['password']);
        Session::set('user_id', $user->id);
        return $this->success('登录成功');
    }

    public function logout()
    {
        Session::delete('user_id');
        return $this->success('注销成功');
    }
}
