<?php
namespace app\admin\widget;

use app\common\controller\Base as BaseController;

class Base extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->view->engine->layout(false);
    }
}
