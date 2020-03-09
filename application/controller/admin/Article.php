<?php
namespace app\controller\admin;

use app\model\Article as ArticleModel;

class Article extends Base
{
    protected function initialize()
    {
        parent::initialize();
        $this->article = new ArticleModel();
    }

    public function index()
    {
        $param = $this->param();

        $map = $this->article->getMap($param);
        $data = $this->article->where($map)->order('sort_order')->select();

        return $this->result($data);
    }

    public function list()
    {
        $param = $this->param();

        $map = $this->article->getMap($param);
        $data = $this->article->where($map)->order('sort_order')->paginate($param['page_size']);

        return $this->result($data);
    }

    public function create()
    {
        $param = $this->param();

        $result = $this->article->create($param);

        if ($result === false) {
            return $this->error($this->article->getError());
        }

        return $this->result($result);
    }

    public function update()
    {
        $param = $this->param();

        $result = $this->article->update($param);

        if ($result === false) {
            return $this->error($this->article->getError());
        }

        return $this->result($result);
    }

    public function delete()
    {
        $id = $this->param('id');

        $result = $this->article->destroy($id);

        if ($result === false) {
            return $this->error($this->article->getError());
        }

        return $this->result($result);
    }
}
