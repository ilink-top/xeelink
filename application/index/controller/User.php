<?php
namespace app\index\controller;

class User extends BaseUser
{
    public function index()
    {
        dump($this->user_info);
    }
}
