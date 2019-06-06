<?php
namespace app\admin\controller;

use app\common\model\ArticleCategory as ArticleCategoryModel;

class ArticleCategory extends BaseAuth
{
    public function __construct(ArticleCategoryModel $model)
    {
        parent::__construct();
        $this->model = $model;
    }

    public function index()
    {
        $this->assign([
            'list' => $this->model->getTree([], 'sort asc, id asc'),
        ]);
        return $this->fetch();
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
            'parent_list' => $this->model->getTree([], 'sort asc, id asc'),
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
            'parent_list' => $this->model->getTree([
                ['id', '<>', $id],
            ], 'sort asc, id asc'),
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
