<?php
namespace app\common\service;

class User extends Base
{
    public static function login($username, $password)
    {
        $user = self::get([
            'username' => $username,
        ]);

        if (empty($user)) {
            self::error('账户不存在');
        }

        if (!bcrypt($password, $user['password'])) {
            self::error('密码错误');
        }

        return $user;
    }
}
