<?php
namespace app\index\controller;

use app\common\service\Article as ArticleService;

class Article extends Base
{
    public function index()
    {
        $param = $this->request->param();
        dump(ArticleService::getPage($param));
    }

    public function info()
    {
        $id = $this->request->param('id', 0);
        $info = ArticleService::get($id);
        if (empty($info)) {
            return $this->error('信息不存在');
        }
        dump($info);
    }
}
