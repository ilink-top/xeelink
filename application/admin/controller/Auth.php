<?php
namespace app\admin\controller;

use app\common\model\Admin;
use think\facade\Session;

class Auth extends Base
{
    public function index()
    {
        if (Session::has('admin_id')) {
            $this->redirect('index/index');
        }
        $this->view->engine->layout(false);
        return $this->fetch('login');
    }

    /**
     * 登录处理
     */
    public function login()
    {
        $param = $this->request->param();

        $validate = $this->validate($param, 'app\common\validate\Admin.login');
        $this->check($validate);

        $user = Admin::login($param['username'], $param['password']);

        Session::set('admin_id', $user->id);

        return $this->jump();
    }

    /**
     * 注销登录
     */
    public function logout()
    {
        Session::delete('admin_id');

        return $this->jump();
    }
}
