<?php
namespace app\controller\admin;

use app\model\Article;
use app\library\Excel;

class Export extends Base
{
    protected function initialize()
    {
        parent::initialize();
        $this->excel = new Excel();
    }

    public function article()
    {
        $param = $this->param();
        $article = new Article();

        $map = $article->getMap($param);
        $data = $article->where($map)->order('sort_order')->cursor();

        return $this->excel->setTitle('用户数据')->setHeader([
            'id' => [
                'title' => 'ID',
                'format' => 'number',
            ],
            'title' => [
                'title' => '标题',
            ],
            'keyword' => [
                'title' => '关键字',
                'format' => 'number',
            ],
        ])->write($data);
    }
}
