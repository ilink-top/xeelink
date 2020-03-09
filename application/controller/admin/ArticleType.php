<?php
namespace app\controller\admin;

use app\model\ArticleType as ArticleTypeModel;

class ArticleType extends Base
{
    protected function initialize()
    {
        parent::initialize();
        $this->articleType = new ArticleTypeModel();
    }

    public function index()
    {
        $param = $this->param();

        $map = $this->articleType->getMap($param);
        $data = $this->articleType->where($map)->order('sort_order')->select();
        $data = get_tree($data);

        return $this->result($data);
    }

    public function create()
    {
        $param = $this->param();

        $result = $this->articleType->create($param);

        if ($result === false) {
            return $this->error($this->articleType->getError());
        }

        return $this->result($result);
    }

    public function update()
    {
        $param = $this->param();

        $result = $this->articleType->update($param);

        if ($result === false) {
            return $this->error($this->articleType->getError());
        }

        return $this->result($result);
    }

    public function delete()
    {
        $id = $this->param('id');

        $result = $this->articleType->destroy($id);

        if ($result === false) {
            return $this->error($this->articleType->getError());
        }

        return $this->result($result);
    }
}
