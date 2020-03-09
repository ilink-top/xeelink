<?php
namespace app\controller\admin;

use app\model\AdminRole as AdminRoleModel;

class AdminRole extends Base
{
    protected function initialize()
    {
        parent::initialize();
        $this->adminRole = new AdminRoleModel();
    }

    public function index()
    {
        $param = $this->param();

        $map = $this->adminRole->getMap($param);
        $data = $this->adminRole->where($map)->order('sort_order')->select();

        return $this->result($data);
    }

    public function list()
    {
        $param = $this->param();

        $map = $this->adminRole->getMap($param);
        $data = $this->adminRole->where($map)->order('sort_order')->paginate($param['page_size']);

        return $this->result($data);
    }

    public function create()
    {
        $param = $this->param();

        $result = $this->adminRole->create($param);

        if ($result === false) {
            return $this->error($this->adminRole->getError());
        }

        return $this->result($result);
    }

    public function update()
    {
        $param = $this->param();

        $result = $this->adminRole->update($param);

        if ($result === false) {
            return $this->error($this->adminRole->getError());
        }

        return $this->result($result);
    }

    public function delete()
    {
        $id = $this->param('id');

        $result = $this->adminRole->destroy($id);

        if ($result === false) {
            return $this->error($this->adminRole->getError());
        }

        return $this->result($result);
    }

    public function menu()
    {
        $roleId = $this->param('role_id');

        $roleInfo = $this->adminRole->find($roleId);
        $menuList = $roleInfo->menu()->select();
        $menuIds = get_column($menuList);

        return $this->result($menuIds);
    }

    public function updateMenu()
    {
        $roleId = $this->param('role_id');
        $permissionIds = $this->param('permission_ids');

        $roleInfo = $this->adminRole->find($roleId);
        $result = $roleInfo->menu()->sync($permissionIds);

        if ($result === false) {
            return $this->error($this->adminRole->getError());
        }

        return $this->result($result);
    }
}
