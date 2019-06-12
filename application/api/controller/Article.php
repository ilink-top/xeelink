<?php
namespace app\api\controller;

use app\common\service\Article as ArticleService;

class Article extends Base
{
    public function index()
    {
        $param = $this->request->param();
        $list = ArticleService::getPage($param);
        return $this->result($list);
    }

    public function info()
    {
        $id = $this->request->param('id', 0);
        $info = ArticleService::get($id);
        if (empty($info)) {
            return $this->error('信息不存在');
        }
        return $this->result($info);
    }
}
