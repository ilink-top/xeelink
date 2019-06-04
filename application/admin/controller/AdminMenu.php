<?php
namespace app\admin\controller;

use app\common\model\AdminMenu as AdminMenuModel;

class AdminMenu extends BaseAuth
{
    public function __construct(AdminMenuModel $model)
    {
        parent::__construct();
        $this->model = $model;
    }

    public function index()
    {
        $list = $this->model->getTree([], 'sort asc, id asc');
        $this->assign([
            'list' => $list,
        ]);
        return $this->fetch();
    }

    public function add()
    {
        $param = $this->request->param();

        if ($this->request->isPost()) {
            $validate = $this->validate($param, 'app\common\validate\Admin.menu');
            $this->check($validate);

            $this->model->saveData($param);

            $this->log();
            return $this->jump();
        }

        $this->assign([
            'data' => [
                'is_show' => $this->model->isShowData,
                'status' => $this->model->statusData,
            ],
            'menu_list' => $this->model->getTree([], 'sort asc, id asc'),
        ]);
        return $this->fetch('edit');
    }

    public function edit()
    {
        $id = $this->request->param('id', 0);
        $param = $this->request->param();

        if ($this->request->isPost()) {
            $validate = $this->validate($param, 'app\common\validate\Admin.menu');
            $this->check($validate);

            $this->model->saveData($param);

            $this->log();
            return $this->jump();
        }

        $this->assign([
            'data' => [
                'is_show' => $this->model->isShowData,
                'status' => $this->model->statusData,
            ],
            'info' => $this->model->get($id),
            'menu_list' => $this->model->getTree([
                ['id', '<>', $id],
            ], 'sort asc, id asc'),
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
