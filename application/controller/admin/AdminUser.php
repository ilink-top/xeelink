<?php
namespace app\controller\admin;

use app\model\AdminUser as AdminUserModel;
use app\validate\Admin;

class AdminUser extends Base
{
    protected function initialize()
    {
        parent::initialize();
        $this->adminUser = new AdminUserModel();
    }

    public function index()
    {
        $param = $this->param();

        $map = $this->adminUser->getMap($param);
        $data = $this->adminUser->where($map)->order('create_time', 'desc')->select();

        return $this->result($data);
    }

    public function list()
    {
        $param = $this->param();

        $map = $this->adminUser->getMap($param);
        $data = $this->adminUser->where($map)->order('create_time', 'desc')->paginate($param['page_size']);

        return $this->result($data);
    }

    public function create()
    {
        $param = $this->param();

        $this->validateResult($param, Admin::class . '.user');

        $result = $this->adminUser->create($param);

        if ($result === false) {
            return $this->error($this->adminUser->getError());
        }

        return $this->result($result);
    }

    public function update()
    {
        $param = $this->param();

        $this->validateResult($param, Admin::class . '.user');

        $result = $this->adminUser->update($param);

        if ($result === false) {
            return $this->error($this->adminUser->getError());
        }

        return $this->result($result);
    }

    public function delete()
    {
        $id = $this->param('id');

        $result = $this->adminUser->destroy($id);

        if ($result === false) {
            return $this->error($this->adminUser->getError());
        }

        return $this->result($result);
    }
}
