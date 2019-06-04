<?php
namespace app\common\validate;

class Demo extends Base
{
    protected $rule = [
        'name' => 'require|max:25',
    ];

    protected $message = [
        'name.require' => '名称必须',
    ];

    protected $scene = [
        'demo' => ['name'],
    ];
}
