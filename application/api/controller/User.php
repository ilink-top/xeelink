<?php
namespace app\api\controller;

use app\common\service\User as UserService;

class User extends BaseUser
{
    public function index()
    {
        return $this->result(UserService::get($this->user_id));
    }
}
