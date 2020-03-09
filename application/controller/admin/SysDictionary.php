<?php
namespace app\controller\admin;

use app\model\SysDictionary as SysDictionaryModel;

class SysDictionary extends Base
{
    protected function initialize()
    {
        parent::initialize();
        $this->sysDictionary = new SysDictionaryModel();
    }

    public function index()
    {
        $param = $this->param();

        $map = $this->sysDictionary->getMap($param);
        $data = $this->sysDictionary->getDictionary($map);

        return $this->result($data);
    }

    public function create()
    {
        $param = $this->param();

        $result = $this->sysDictionary->create($param);

        if ($result === false) {
            return $this->error($this->sysDictionary->getError());
        }

        return $this->result($result);
    }

    public function update()
    {
        $param = $this->param();

        $result = $this->sysDictionary->update($param);

        if ($result === false) {
            return $this->error($this->sysDictionary->getError());
        }

        return $this->result($result);
    }

    public function delete()
    {
        $id = $this->param('id');

        $result = $this->sysDictionary->destroy($id);

        if ($result === false) {
            return $this->error($this->sysDictionary->getError());
        }

        return $this->result($result);
    }
}
