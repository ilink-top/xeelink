<?php
namespace app\http\middleware;

use think\Container;

class Base
{
    public function __construct()
    {
        $this->app = Container::get('app');
    }
}
