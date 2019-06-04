<?php
namespace app\admin\controller;

class Auth extends Base
{
    public function index()
    {
        if ($this->auth->isLogin()) {
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

        $this->auth->login($param['username'], $param['password']);
        $this->log('用户登录', $this->auth->isLogin());

        return $this->jump();
    }

    /**
     * 注销登录
     */
    public function logout()
    {
        $this->auth->logout();

        return $this->jump();
    }
}
