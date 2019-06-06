<?php
namespace app\admin\controller;

use app\common\model\AdminLog as AdminLogModel;

class AdminLog extends BaseAuth
{
    public function __construct(AdminLogModel $model)
    {
        parent::__construct();
        $this->model = $model;
    }

    public function index()
    {
        $this->assign([
            'list' => $this->model->getAll(),
        ]);
        return $this->fetch();
    }

    public function delete()
    {
        $id = $this->request->param('id', 0);

        $this->model->deleteData($id);

        return $this->jump();
    }
}
