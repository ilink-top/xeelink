<?php
namespace app\controller\admin;

use app\model\AdminDepartment as AdminDepartmentModel;

class AdminDepartment extends Base
{
    protected function initialize()
    {
        parent::initialize();
        $this->adminDepartment = new AdminDepartmentModel();
    }

    public function index()
    {
        $param = $this->param();

        $map = $this->adminDepartment->getMap($param);
        $data = $this->adminDepartment->where($map)->order('sort_order')->select();
        $data = get_tree($data);

        return $this->result($data);
    }

    public function create()
    {
        $param = $this->param();

        $result = $this->adminDepartment->create($param);

        if ($result === false) {
            return $this->error($this->adminDepartment->getError());
        }

        return $this->result($result);
    }

    public function update()
    {
        $param = $this->param();

        $result = $this->adminDepartment->update($param);

        if ($result === false) {
            return $this->error($this->adminDepartment->getError());
        }

        return $this->result($result);
    }

    public function delete()
    {
        $id = $this->param('id');

        $result = $this->adminDepartment->destroy($id);

        if ($result === false) {
            return $this->error($this->adminDepartment->getError());
        }

        return $this->success();
    }

    public function leader()
    {
        $departmentId = $this->param('dept_id');

        $departmentInfo = $this->adminDepartment->find($departmentId);
        $leaderList = $departmentInfo->leader()->select();

        return $this->result(get_column($leaderList));
    }
}
