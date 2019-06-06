<?php
namespace app\common\model;

use think\facade\Config;

class AdminMenu extends Base
{
    protected $auto = ['is_show', 'status'];

    public $isShowData = [
        0 => '隐藏',
        1 => '显示',
    ];

    public $statusData = [
        0 => '禁用',
        1 => '启用',
    ];

    public function scopeIsShow($query)
    {
        $query->where('is_show', 1);
    }

    public function scopeStatus($query)
    {
        $query->where('status', 1);
    }

    public function setIconAttr($value)
    {
        return $value ?: 'fa-circle-o';
    }

    public function setIsShowAttr($value)
    {
        return $value ?: 0;
    }

    public function setStatusAttr($value)
    {
        return $value ?: 0;
    }

    public function getIsShowTextAttr($value, $data)
    {
        return $this->isShowData[$data['is_show']];
    }

    public function getStatusTextAttr($value, $data)
    {
        return $data['status'] ? '<span class="badge bg-green">' . $this->statusData[$data['status']] . '</span>' : '<span class="badge bg-red">' . $this->statusData[$data['status']] . '</span>';
    }

    public function auth()
    {
        return $this->belongsToMany('AdminAuth', 'AdminAuthMenu', 'auth_id', 'menu_id');
    }

    public static function deleteData($id)
    {
        $disableCount = self::getInstance()
            ->where('parent_id', 'in', $id)
            ->where('id', 'not in', $id)
            ->count();
        if ($disableCount > 0) {
            self::error('有子选项不可删除');
        }

        return self::transaction(function () use ($id) {
            parent::deleteData($id);
            AdminAuthMenu::where('menu_id', 'in', $id)->delete();
        });
    }

    /**
     * 获取默认页面标题
     */
    public static function getTitle($url)
    {
        $info = self::get(function ($query) use ($url) {
            $query->scope('status')->where('url', $url);
        });
        return !empty($info) ? $info->title : '';
    }

    /**
     * 获取面包屑
     */
    public static function getCrumbs($where = '')
    {
        $info = self::get(function ($query) use ($where) {
            $query->scope('status')->where($where)->order('parent_id desc');
        });
        $crumbs = [];
        if (!empty($info)) {
            if ($info->parent_id) {
                $crumbs = self::getCrumbs(['id' => $info['parent_id']]);
            }
            $crumbs[] = $info;
        }
        return $crumbs;
    }

    /**
     * 获取菜单视图
     */
    public static function getMenuView($crumbs, $where)
    {
        $where[] = ['is_show', '=', 1];
        $where[] = ['status', '=', 1];
        $menuList = self::getAll($where, 'sort asc, id asc', 'id, parent_id, title, url, icon');
        $menuTree = tree($menuList);
        $crumbIds = array_column($crumbs, 'id');
        return self::treeView($menuTree, $crumbIds);
    }

    /**
     * 获取菜单视图HTML
     */
    private static function treeView($tree, $crumbIds)
    {
        $view = '';
        foreach ($tree as $menu) {
            $active = in_array($menu['id'], $crumbIds) ? ' active' : '';
            $class = $pullRight = $treeviewMenu = '';
            if (isset($menu['sub'])) {
                $class = ' treeview';
                $pullRight = '<span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>';
                $treeviewMenu = '<ul class="treeview-menu">' . self::treeView($menu['sub'], $crumbIds) . '</ul>';
            }
            $url = $menu['url'] ? url($menu['url']) : '#';
            $view .= '<li class="' . $active . $class . '">
                <a href="' . $url . '">
                    <i class="' . $menu['icon'] . '"></i> <span>' . $menu['title'] . '</span>
                    ' . $pullRight . '
                </a>
                ' . $treeviewMenu . '
            </li>';
        }
        return $view;
    }

    /**
     * 面包屑导航
     */
    public static function getCrumbsView($crumbs)
    {
        $view = '';
        $i = 0;
        $view = '<li><a href="' . url('index/index') . '"><i class="fa fa-home"></i>系统首页</a></li>' . PHP_EOL;
        foreach ($crumbs as $crumb) {
            $i++;
            $active = '';
            $title = $crumb->title;
            $url = $crumb->url ? 'href="' . url($crumb->url) . '"' : '';
            if ($i == count($crumbs)) {
                $active = 'class="active"';
            } else {
                $title = '<a ' . $url . '>' . $title . '</a>';
            }
            $view .= '<li ' . $active . '>' . $title . '</li>' . PHP_EOL;
        }
        return $view;
    }

    /**
     * 过滤HTML
     */
    public static function htmlFilter($html, $uid)
    {
        $preg = '/<a .*?href="(.*?)".*?>.*?<\/a>/is';
        preg_match_all($preg, $html, $match);
        foreach ($match[1] as $key => $url) {
            if (!self::urlFilter($url, $uid)) {
                $html = str_replace($match[0][$key], '', $html);
            }
        }
        return $html;
    }

    /**
     * 判断链接是否需要过滤
     */
    private static function urlFilter($url, $uid)
    {
        $url = str_replace(dirname(request()->baseFile()), '', $url);
        $url = ltrim($url, '/');
        $url = str_replace('.' . Config::get('url_html_suffix'), '', $url);
        $path = path($url);
        $url = $path['controller'] . '/' . $path['action'];
        $auth = new Auth(Config::pull('auth'));

        // 空链接
        if ($url == '#' || empty($url)) {
            return true;
        }

        // 非admin模块
        if ($path['module'] != 'admin') {
            return true;
        }

        // 链接不在菜单表里
        if (!self::get(['url' => $url])) {
            return true;
        }

        // 通过验证
        if ($auth->check($url, $uid)) {
            return true;
        }

        return false;
    }
}
