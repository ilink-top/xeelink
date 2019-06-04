<?php
namespace app\index\controller;

class Index extends Base
{
    public function index()
    {
        dump(\helper\Data::md5_random());
    }
}
