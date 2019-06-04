<?php
namespace app\admin\controller;

use app\common\model\Admin;

class Index extends BaseLogin
{
    public function index()
    {
        $uploadMaxFilesize = file_size_format(get_cfg_var('upload_max_filesize'));
        $admin = new Admin();
        $this->assign([
            'site_title' => '系统首页',
            'info' => [
                '操作系统' => PHP_OS,
                'PHP版本' => PHP_VERSION,
                'ThinkPHP版本' => $this->app->version(),
                '上传图片限制' => file_size((int) min($uploadMaxFilesize, config('file.imageMaxSize'))),
                '上传文件限制' => file_size((int) min($uploadMaxFilesize, config('file.fileMaxSize'))),
                '执行时间限制' => get_cfg_var('max_execution_time') . '秒',
            ],
            'admin_list' => $admin->lastLogin(),
        ]);
        return $this->fetch();
    }

    public function profile()
    {
        $param = $this->request->param();
        $admin = new Admin();

        if ($this->request->isPost()) {
            $admin->saveProfile($param);

            $this->log('编辑个人信息');
            return $this->jump();
        }

        $this->assign([
            'site_title' => '个人信息',
            'info' => $admin->get($this->user_id),
        ]);
        return $this->fetch();
    }
}
