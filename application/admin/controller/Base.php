<?php
namespace app\admin\controller;

use app\common\controller\Base as BaseController;
use app\common\model\AdminLog;
use app\common\model\Auth;

class Base extends BaseController
{
    protected $auth;
    protected $user_id;
    protected $user_info;

    public function __construct()
    {
        parent::__construct();
        $this->auth = new Auth(config('auth.'));
        $this->user_id = $this->auth->isLogin();
        $this->user_info = $this->auth->getUserInfo($this->user_id);
    }

    final protected function url()
    {
        $path = path();
        return $path['controller'] . '/' . $path['action'];
    }

    final protected function log($name = '', $uid = 0, $url = '')
    {
        if (!setting('open_admin_log')) {
            return false;
        }
        $uid = $uid ?: $this->user_id;
        $url = $url ?: $this->url();
        return AdminLog::saveLog($uid, $url, $name);
    }

    protected function jump($url = 'index', $data = [], $msg = '操作成功')
    {
        return $this->success($msg, $url, $data);
    }

    protected function check($msg = true)
    {
        if ($msg !== true) {
            return $this->error($msg ? $msg : '操作失败');
        }
    }

    public function _empty()
    {
        return $this->fetch();
    }
}
