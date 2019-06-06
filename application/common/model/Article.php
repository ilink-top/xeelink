<?php
namespace app\common\model;

use think\model\concern\SoftDelete;

class Article extends Base
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $defaultSoftDelete = 0;
    protected $autoWriteTimestamp = true;

    public function category()
    {
        return $this->belongsTo('ArticleCategory', 'category_id');
    }
}
