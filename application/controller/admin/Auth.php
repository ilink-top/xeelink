<?php
namespace app\controller\admin;

use app\model\AdminUser;
use app\validate\Admin;

class Auth extends Base
{
    protected $middleware = [];

    public function login()
    {
        $param = $this->param();

        $this->validateResult($param, Admin::class . '.login');

        $userInfo = AdminUser::where(['user_name' => $param['account']])->find();
        if (is_empty($userInfo)) {
            $this->error('用户不存在');
        }
        if ($this->app->hash->check($param['password'], $userInfo->password) === false) {
            $this->error('密码错误');
        }

        $token = $this->app->admin->tokenEncode([
            'id' => $userInfo->id,
        ]);

        return $this->result($token);
    }

    public function logout()
    {
        return $this->success();
    }
}
