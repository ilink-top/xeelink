<?php
namespace app\controller\admin;

use app\model\AdminMenu as AdminMenuModel;

class AdminMenu extends Base
{
    protected function initialize()
    {
        parent::initialize();
        $this->adminMenu = new AdminMenuModel();
    }

    public function index()
    {
        $param = $this->param();

        $map = $this->adminMenu->getMap($param);
        $data = $this->adminMenu->where($map)->order('sort_order')->select();
        $data = get_tree($data);

        return $this->result($data);
    }

    public function create()
    {
        $param = $this->param();

        $result = $this->adminMenu->create($param);

        if ($result === false) {
            return $this->error($this->adminMenu->getError());
        }

        return $this->result($result);
    }

    public function update()
    {
        $param = $this->param();

        $result = $this->adminMenu->update($param);

        if ($result === false) {
            return $this->error($this->adminMenu->getError());
        }

        return $this->result($result);
    }

    public function delete()
    {
        $id = $this->param('id');

        $result = $this->adminMenu->destroy($id);

        if ($result === false) {
            return $this->error($this->adminMenu->getError());
        }

        return $this->result($result);
    }
}
