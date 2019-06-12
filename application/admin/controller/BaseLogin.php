<?php
namespace app\admin\controller;

use app\common\model\AdminLog;
use app\common\model\AdminMenu;
use app\common\model\Auth;
use think\facade\Config;
use think\facade\Session;

class BaseLogin extends Base
{
    protected $auth;
    protected $user_id;
    protected $user_info;
    public function __construct()
    {
        parent::__construct();
        $this->checkLogin();
        $this->initAdmin();
    }

    final private function checkLogin()
    {
        if (!Session::has('admin_id')) {
            $this->redirect('auth/index');
        }
        $this->auth = new Auth(Config::pull('auth'));
        $this->user_id = Session::get('admin_id');
        $this->user_info = $this->auth->getUserInfo($this->user_id);
    }

    final private function initAdmin()
    {
        $menuModel = new AdminMenu();

        // 内容过滤
        $this->view->filter(function ($content) use ($menuModel) {
            return $menuModel->htmlFilter($content, $this->user_id);
        });

        // 当前链接
        $url = $this->url();
        // 面包屑
        $crumbs = $menuModel->getCrumbs(['url' => $url]);

        // 菜单权限
        $menuMap = [];
        if (!$this->auth->isAdmin($this->user_id)) {
            $menuMap['id'] = $this->auth->getAuthIds($this->user_id);
        }

        $this->assign([
            // 登录会员信息
            'user_info' => $this->user_info,
            // 设置页面标题
            'site_title' => $menuModel->getTitle($url),
            // 菜单视图
            'menu_view' => $menuModel->getMenuView($crumbs, $menuMap),
            // 面包屑视图
            'crumbs_view' => $menuModel->getCrumbsView($crumbs),
        ]);
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
}
