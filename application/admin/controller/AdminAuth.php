<?php
namespace app\admin\controller;

use app\common\model\AdminAuth as AdminAuthModel;
use app\common\model\AdminMenu;

class AdminAuth extends BaseAuth
{
    public function __construct(AdminAuthModel $model)
    {
        parent::__construct();
        $this->model = $model;
    }

    public function index()
    {
        $this->assign([
            'list' => $this->model->getAll([], 'sort asc, id asc'),
        ]);
        return $this->fetch();
    }

    public function add()
    {
        $param = $this->request->param();

        if ($this->request->isPost()) {
            $validate = $this->validate($param, 'app\common\validate\Admin.auth');
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
            $validate = $this->validate($param, 'app\common\validate\Admin.auth');
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

    public function menu()
    {
        $id = $this->request->param('id', 0);
        $menu_ids = $this->request->param('menu_ids', []);

        if ($this->request->isPost()) {
            $this->model->saveMenu($id, $menu_ids);

            $this->log();
            return $this->jump();
        }

        $this->assign([
            'list' => AdminMenu::getTree(),
            'info' => [
                'id' => $id,
                'menu_ids' => $this->model->get($id)->menu()->column('id'),
            ],
        ]);
        return $this->fetch();
    }
}
