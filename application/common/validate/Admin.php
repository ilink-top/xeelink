<?php
namespace app\common\validate;

class Admin extends Base
{
    protected $rule = [
        // Admin
        'username|账号' => 'require|unique:Admin',
        'password|密码' => 'require',
        'verify|验证码' => 'require|captcha',
        // Auth
        'name|名称' => 'require',
        // Menu
        'title|标题' => 'require',
        'url|链接' => 'unique:AdminMenu',
    ];

    protected $scene = [
        'admin' => ['username'],
        'auth' => ['name'],
        'menu' => ['title', 'url'],
    ];

    public function sceneLogin()
    {
    	return $this->only(['username', 'password', 'verify'])
            ->remove('username', 'unique');
    }
}
