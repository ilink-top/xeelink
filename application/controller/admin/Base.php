<?php
namespace app\controller\admin;

use app\controller\ApiController as Controller;

class Base extends Controller
{
    protected $middleware = [
        'AdminAuth',
    ];
}