<?php
namespace app\admin\controller;

use app\common\model\SystemPlugin as SystemPluginModel;

class SystemPlugin extends BaseAuth
{
    public function __construct(SystemPluginModel $model)
    {
        parent::__construct();
        $this->model = $model;
    }

    public function index()
    {
        $this->assign([
            'list' => $this->model->getType(),
        ]);
        return $this->fetch();
    }

    public function driver()
    {
        $type = $this->request->param('type', '');
        $this->assign([
            'type' => $type,
            'list' => $this->model->getDriver($type),
            'driver' => array_keys($this->model->driver(['type' => $type])),
        ]);
        return $this->fetch();
    }

    public function add()
    {
        $param = $this->request->param();

        if ($this->request->isPost()) {
            $this->model->saveData($param);

            $this->log();
            return $this->jump(url('driver', ['type' => $param['type']]));
        }

        $this->assign([
            'data' => [
                'status' => $this->model->statusData,
            ],
            'info' => $this->model->getDriverInfo($param['driver'], $param['type']),
            'config' => $this->model->getDriverParam($param['driver'], $param['type']),
        ]);
        return $this->fetch('edit');
    }

    public function edit()
    {
        $param = $this->request->param();
        $where = [
            'type' => $param['type'],
            'driver' => $param['driver'],
        ];
        $info = $this->model->get($where);

        if ($this->request->isPost()) {
            $this->model->saveData($param, $where);

            $this->log();
            return $this->jump(url('driver', ['type' => $param['type']]));
        }

        $this->assign([
            'data' => [
                'status' => $this->model->statusData,
            ],
            'info' => $info,
            'config' => $this->model->getDriverParam($param['driver'], $param['type']),
        ]);
        return $this->fetch();
    }

    public function delete()
    {
        $param = $this->request->param();

        $this->model->uninstall($param['type'], $param['driver']);

        $this->log();
        return $this->jump();
    }
}
