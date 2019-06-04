<?php
namespace app\admin\controller;

use app\common\model\AdminMenu;

class BaseLogin extends Base
{
    public function __construct()
    {
        parent::__construct();

        // 验证登录
        if (!$this->user_id) {
            $this->redirect('auth/index');
        }

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
}
