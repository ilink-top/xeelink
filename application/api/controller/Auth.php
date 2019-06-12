<?php
namespace app\api\controller;

use app\common\service\User;
use Firebase\JWT\JWT;

class Auth extends Base
{
    public function login()
    {
        $param = $this->request->param();
        $user = User::login($param['username'], $param['password']);
        $result = $this->createJwt($user->id);
        return $this->result($result);
    }

    public function refresh()
    {
        $config = config('jwt.');
        $jwt = input('post.token');
        $authInfo = JWT::decode($jwt, $config['key'], $config['allowed_algs']);
        $result = $this->createJwt($authInfo->user_id);
        return $this->result($result);
    }

    private function createJwt($userId)
    {
        $config = config('jwt.');
        $token = $config['token'];
        $time = time();
        $expire = $time + $config['expire'];
        $token['iat'] = $time;
        $token['nbf'] = $time;
        $token['exp'] = $expire;
        $token['user_id'] = $userId;
        $jwt = JWT::encode($token, $config['key']);
        return [
            'token' => $jwt,
            'expire' => $expire
        ];
    }
}
