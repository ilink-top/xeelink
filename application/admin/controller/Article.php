<?php
namespace app\admin\controller;

use app\common\model\Article as ArticleModel;
use app\common\model\ArticleCategory;

class Article extends BaseAuth
{
    public function __construct(ArticleModel $model)
    {
        parent::__construct();
        $this->model = $model;
    }

    public function index()
    {
        $param = $this->request->param();
        $where = $this->map($param);

        $this->assign([
            'info' => $param,
            'list' => $this->model->getAll($where),
            'category_list' => ArticleCategory::getTree([], 'sort asc, id asc'),
        ]);
        return $this->fetch();
    }

    private function map($param)
    {
        $map = [];
        if (isset($param['category_id']) && $param['category_id']) {
            $category_list = ArticleCategory::getAll([], 'sort asc, id asc');
            $children_ids = children_ids($category_list, $param['category_id']);
            $children_ids[] = $param['category_id'];
            $map[] = ['category_id', 'in', $children_ids];
        }
        if (isset($param['keyword']) && $param['keyword']) {
            $map[] = ['title', 'like', '%' . $param['keyword'] . '%'];
        }

        return $map;
    }

    public function add()
    {
        $param = $this->request->param();

        if ($this->request->isPost()) {
            $this->model->saveData($param);

            $this->log();
            return $this->jump();
        }

        $this->assign([
            'category_list' => ArticleCategory::getTree([], 'sort asc, id asc'),
        ]);
        return $this->fetch('edit');
    }

    public function edit()
    {
        $id = $this->request->param('id', 0);
        $param = $this->request->param();

        if ($this->request->isPost()) {
            $this->model->saveData($param);

            $this->log();
            return $this->jump();
        }

        $this->assign([
            'info' => $this->model->get($id),
            'category_list' => ArticleCategory::getTree([], 'sort asc, id asc'),
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
