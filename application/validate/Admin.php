<?php
namespace app\validate;

class Admin extends Base
{
    protected $rule = [
        'account' => 'require',
        'password' => 'require',
        'user_name' => 'require|unique:admin_user',
        'email' => 'require|unique:admin_user',
        'mobile' => 'require|unique:admin_user',
    ];

    protected $message = [
        'account.require' => '请输入用户名',
        'password.require' => '请输入密码',
        'user_name.require' => '请输入用户名',
        'user_name.unique' => '用户名已存在',
        'email.require' => '请输入邮箱',
        'email.unique' => '邮箱已存在',
        'mobile.require' => '请输入手机',
        'mobile.unique' => '手机已存在',
    ];

    protected $scene = [
        'login' => ['account', 'password'],
        'user' => ['user_name', 'email', 'mobile'],
    ];
}
