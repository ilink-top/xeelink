<?php
namespace app\admin\controller;

class SystemData extends BaseLogin
{
    public function area()
    {
        return json([
            1 => '北京',
            2 => '上海',
        ]);
    }
}
