<?php
namespace app\library;

use app\model\AdminUser;
use Firebase\JWT\JWT;

class Admin
{
    protected $user;

    public function id()
    {
        if ($this->user()) {
            return $this->user()->id;
        }
    }

    public function user()
    {
        if (is_empty($this->user)) {
            $this->checkToken();
        }

        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    public function getToken()
    {
        $request = app('request');
        return $request->header('admin-token', $request->param('token'));
    }

    public function checkToken()
    {
        try {
            $token = $this->getToken();
            $userInfo = $this->tokenDecode($token);
            $this->setUser($userInfo);
        } catch (\Exception $e) {
            exception('登录超时或未登录', ErrorCode::TOKEN_ERROR);
        }

        return true;
    }

    public function checkAuth($auth, $userId = null)
    {
        if (empty($userId)) {
            $userId = $this->id();
        }

        $menuList = AdminUser::find($userId)->getMenu();
        if (in_array($auth, get_column($menuList, 'unique_id')) == false) {
            exception('没有权限', ErrorCode::AUTH_ERROR);
        }

        return true;
    }

    public function tokenEncode($data)
    {
        $config = app('config')->get('token.jwt');
        $time = time();
        $expire = $time + $config['expire_time'];
        $jwt = [
            'iss' => $config['iss'],
            'aud' => $config['aud'],
            'iat' => $time,
            'nbf' => $time,
            'exp' => $expire,
            'data' => $data,
        ];
        $token = JWT::encode($jwt, $config['key']);

        return [
            'token' => $token,
            'expire' => $expire,
        ];
    }

    public function tokenDecode($token)
    {
        $config = app('config')->get('token.jwt');
        $jwt = JWT::decode($token, $config['key'], ['HS256']);
        return $jwt->data;
    }
}
