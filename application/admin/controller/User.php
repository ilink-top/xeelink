<?php
namespace app\admin\controller;

use app\common\model\User as UserModel;

class User extends BaseAuth
{
    public function __construct(UserModel $model)
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

    private function map($param)
    {
        $map = [];
        if (isset($param['status']) && $param['status'] != -1) {
            $map[] = ['status', '=', $param['status']];
        }
        if (isset($param['keyword']) && $param['keyword']) {
            $map[] = ['username|nickname', 'like', '%' . $param['keyword'] . '%'];
        }

        return $map;
    }

    public function add()
    {
        $param = $this->request->param();

        if ($this->request->isPost()) {
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
