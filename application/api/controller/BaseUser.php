<?php
namespace app\api\controller;

use Firebase\JWT\JWT;

class BaseUser extends Base
{
    protected $user_id;

    protected function initialize()
    {
        parent::initialize();
        $this->user_id = $this->checkToken();
    }

    public function checkToken()
    {
        $token = $this->request->header('authorization');
        if (empty($token)) {
            return $this->error('Token不存在，拒绝访问');
        }
        $config = config('jwt.');
        $authInfo = (array) JWT::decode($token, $config['key'], $config['allowed_algs']);
        if (empty($authInfo['user_id'])) {
            return $this->error('Token验证不通过,用户不存在');
        }
        return $authInfo['user_id'];
    }
}
