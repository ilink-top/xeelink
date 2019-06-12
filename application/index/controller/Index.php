<?php
namespace app\index\controller;
use app\common\service\ArticleCategory as ArticleCategoryService;

class Index extends Base
{
    public function index()
    {
        dump(ArticleCategoryService::getALl([], 'sort asc'));
    }
}
