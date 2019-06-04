<?php
namespace app\admin\controller;

use app\common\model\SystemDemo as SystemDemoModel;

class SystemDemo extends BaseAuth
{
    public function __construct(SystemDemoModel $model)
    {
        parent::__construct();
        $this->model = $model;
    }

    public function index()
    {
        $param = $this->request->param();
        $where = $this->map($param);

        $this->assign([
            'data' => [
                'status' => $this->model->statusData,
            ],
            'info' => $param,
            'list' => $this->model->getAll($where),
        ]);
        return $this->fetch();
    }

    public function page()
    {
        $param = $this->request->param();
        $where = $this->map($param);

        $this->assign([
            'data' => [
                'status' => $this->model->statusData,
            ],
            'info' => $param,
            'list' => $this->model->getPage($where),
        ]);
        return $this->fetch();
    }

    private function map($param)
    {
        $map = [];
        if (isset($param['status']) && $param['status'] != -1) {
            $map[] = ['status', '=', $param['status']];
        }
        if (isset($param['keyword']) && $param['keyword']) {
            $map[] = ['name', 'like', '%' . $param['keyword'] . '%'];
        }

        return $map;
    }

    public function add()
    {
        $param = $this->request->param();

        if ($this->request->isPost()) {
            $validate = $this->validate($param, 'app\common\validate\Demo.demo');
            $this->check($validate);

            $this->model->saveData($param);

            $this->log();
            return $this->jump();
        }

        $this->assign([
            'data' => [
                'status' => $this->model->statusData,
            ],
        ]);
        return $this->fetch('edit');
    }

    public function edit()
    {
        $id = $this->request->param('id', 0);
        $param = $this->request->param();

        if ($this->request->isPost()) {
            $validate = $this->validate($param, 'app\common\validate\Demo.demo');
            $this->check($validate);

            $this->model->saveData($param);

            $this->log();
            return $this->jump();
        }

        $this->assign([
            'data' => [
                'status' => $this->model->statusData,
            ],
            'info' => $this->model->get($id),
        ]);
        return $this->fetch();
    }

    public function delete()
    {
        $id = $this->request->param('id', 0);

        $this->model->deleteData($id);

        $this->log();
        return $this->jump();
    }
}
