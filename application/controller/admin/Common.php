<?php
namespace app\controller\admin;

use app\model\AdminMenu;
use app\model\AdminUser;
use app\validate\Admin;

class Common extends Base
{
    protected $middleware = [
        'AdminLogin',
    ];

    public function upload()
    {
        $file = $this->request->file('file');

        $info = $file->move(config('custom.upload_path'));
        if ($info === false) {
            $this->error($file->getError());
        }

        return $this->result([
            'size' => $info->getSize(),
            'original_name' => $info->getInfo('name'),
            'path' => file_path($info->getSaveName()),
        ]);
    }

    public function userInfo()
    {
        $userId = $this->app->admin->id();
        $userInfo = AdminUser::find($userId);

        $menuList = $userInfo->getShowMenu();
        $userInfo->permission = get_column($menuList, 'unique_id');
        $topId = AdminMenu::get(['unique_id' => 'admin'])->id;
        $userInfo->menu = get_tree($menuList, $topId);

        return $this->result($userInfo);
    }

    public function updateUserInfo()
    {
        $param = $this->param();
        $param['user_id'] = $this->app->admin->id();

        $this->validateResult($param, Admin::class . '.user');

        $adminUser = new AdminUser();
        $result = $adminUser->update($param);

        if ($result === false) {
            return $this->error($adminUser->getError());
        }

        return $this->result($result);
    }
}
