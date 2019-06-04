<?php
namespace app\admin\controller;

use app\common\model\Admin as AdminModel;
use app\common\model\AdminAuth;

class Admin extends BaseAuth
{
    public function __construct(AdminModel $model)
    {
        parent::__construct();
        $this->model = $model;
    }

    public function index()
    {
        $this->assign([
            'list' => $this->model->getAll([], 'id asc'),
        ]);
        return $this->fetch();
    }

    public function add()
    {
        $param = $this->request->param();

        if ($this->request->isPost()) {
            $validate = $this->validate($param, 'app\common\validate\Admin.admin');
            $this->check($validate);

            $this->model->saveData($param);

            $this->log();
            return $this->jump();
        }

        return $this->fetch('edit');
    }

    public function edit()
    {
        $id = $this->request->param('id', 0);
        $param = $this->request->param();

        if ($this->request->isPost()) {
            $validate = $this->validate($param, 'app\common\validate\Admin.admin');
            $this->check($validate);

            $this->model->saveData($param);

            $this->log();
            return $this->jump();
        }

        $this->assign([
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

    public function auth()
    {
        $id = $this->request->param('id', 0);
        $auth_ids = $this->request->param('auth_ids', []);

        if ($this->request->isPost()) {
            $this->model->saveAuth($id, $auth_ids);

            $this->log();
            return $this->jump();
        }

        $this->assign([
            'list' => AdminAuth::getAll([], 'sort asc, id asc'),
            'info' => [
                'id' => $id,
                'auth_ids' => $this->model->get($id)->auth()->column('id'),
            ],
        ]);
        return $this->fetch();
    }
}
