<?php
namespace app\admin\controller;

use app\common\model\SystemSetting as SystemSettingModel;
use app\common\model\SystemPlugin;

class SystemSetting extends BaseAuth
{
    public function __construct(SystemSettingModel $model)
    {
        parent::__construct();
        $this->model = $model;
    }

    public function index()
    {
        $param = $this->request->param();

        if ($this->request->isPost()) {
            $this->model->saveSetting($param);

            $this->log();
            return $this->jump();
        }

        $this->assign([
            'info' => setting(),
            'storage_plugin_list' => SystemPlugin::driver(['type' => 'storage']),
        ]);

        return $this->fetch();
    }
}
